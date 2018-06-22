var config = require('./config.json');
var childThemePath=config.childThemePath;
var parentThemePath=config.parentThemePath;
var site=config.site;

var gulp = require('gulp');
var sass = require('gulp-sass');
var runSequence = require('run-sequence');
var browserSync = require('browser-sync');
var gutil = require( 'gulp-util' );
var ftp = require( 'vinyl-ftp' );
var sourcemaps = require('gulp-sourcemaps');
const del = require('del');

const autoprefixer = require('gulp-autoprefixer');
gulp.task('tree', function () {
    return gulp.src('*.*', {read: false})
    .pipe(gulp.dest('./src'))
    .pipe(gulp.dest('./src/scss'))
    .pipe(gulp.dest('./src/js'))
});

// Watchers
gulp.task('watch', function() {
  gulp.watch('src/css/**/*.css', ['sass']);
  gulp.watch('src/**/*.scss', ['sass']);
  gulp.watch('src/js/**/*.js', browserSync.reload);
  gulp.watch(childThemePath+'/**/*.php', browserSync.reload);
})

gulp.task('initStorefront', function(){
  gulp.src([parentThemePath+'/style.scss'])
    .pipe(sass({
        includePaths: [require('node-bourbon').includePaths,'node_modules/susy/sass/']
    }).on('error', sass.logError))
    .pipe(autoprefixer({
           browsers: ['last 2 versions'],
           cascade: false
       }))
    .pipe(gulp.dest(parentThemePath))

});
gulp.task('sass', function(){
  gulp.src(['src/*.scss'])
   .pipe(sourcemaps.init())
    .pipe(sass({
      includePaths: [require('node-bourbon').includePaths,'node_modules/susy/sass/']
    }).on('error', sass.logError))
    .pipe(autoprefixer({
           browsers: ['last 2 versions'],
           cascade: false
       }))
    .pipe(sourcemaps.write('.'))
    .pipe(gulp.dest(childThemePath))
    .pipe(browserSync.reload({ // Reloading with Browser Sync
      stream: true
    }));
});
gulp.task('browserSync', function() {
  browserSync({
    proxy: site,
    port: 80,
  })
})
gulp.task( 'deploy', function () {

    var conn = ftp.create( {
        host:     config.ftp_host,
        user:     config.ftp_user,
        password: config.ftp_pasw,
        parallel: 10,
        log:      gutil.log
    } );

    var globs = [
        themePath+'/**',
    ];

    // using base = '.' will transfer everything to /public_html correctly
    // turn off buffering in gulp.src for best performance

    return gulp.src( globs, { base: './', buffer: false } )
        .pipe( conn.newer( config.ftp_path ) ) // only upload newer files
        .pipe( conn.dest( config.ftp_path ) );

} );

gulp.task('default', function(callback) {
  runSequence(['sass', 'browserSync'], 'watch',
    callback
  )
})
gulp.task('clean-git', function () {
  return del([
    'wp/**/.git',
    // possiamo evitare la cancellazione in specifici pattern con il "!"
    //'!wp/**/plugin/.git'
  ]);
});
