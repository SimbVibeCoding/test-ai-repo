### Required ###
* [nodejs](https://nodejs.org/en/download/)
* [npm](https://www.npmjs.com/get-npm) - installato con Node.js
* [composer](https://getcomposer.org/Composer-Setup.exe)

## Su bitbucket creare la ropository del progetto (inserire un file readme) ##
## creare il progetto locale ##
* da shell clonare la repository del retina-bootstrap-installer nella cartella del nuovo progetto
``` git clone https://formazioneRetina@bitbucket.org/retina_sviluppo/retina-bootstrap-installer.git cartellanuovoprogetto```
* portarsi nella cartellanuovoprogetto
* reimpostare la remote repository su quella del nuovo progetto
``` git remote -v (mostra elenco delle attuali repository)```
``` git remote set-url origin user@bitbucket.org/nuovoprogetto.git```
``` git remote -v (mostra elenco aggiornato alla nuova repository)```

digitare il comando git clean-git per pulire tutte le .git

pushare il contenuto nella nuova repository
``` git push -f ```

* da shell scaricare il core di wordpress itemi e i plugin (verr� installato nella cartella 'wp')
```composer install```
> vengono installati i pacchetti indicati nel file composer.json. Per rimuovere:  ```composer remove johnpbloch/wordpress```
* NOTE: la versione di ACF Pro è fissata alla 5.6.8 verificare manualmente aggiornamenti successivi
* da shell, installiamo i pacchetti necessari a Gulp (ignorare i "WARN")
```npm install```
> vengono installati i pacchetti indicati nel file package.json
viene creata la cartella node_modules (serve solo durante la fase di sviluppo non va committata ne pubblicata)
per verifica digitare da shell
```npm list --depth=0```
* vengono mostrati i pacchetti installati
  + gulp
  + gulp-sass (compilatore sass)
  + bourbon (mixin sass)
  + susy (grid-system sass)
  + browsersync (proxy per la sincronizzazione e il refresh automatico del browser)
  + runsequence (accodamento di task asincroni)

* aprire il file CONFIG.json e impostare i valori del progetto
  + "themePath" : percorso del tema child (default="wp/wp-content/themes/storefront-child/"),
  + "site" : url del sito come impostato in localhost,
  + "ftp_host":"" host del sito remoto,
  + "ftp_user":"",
  + "ftp_pasw":"",
  + "ftp_path":"/web/dominio.ext/public_html"


* da shell digitare il comando
```gulp```
verra visualizzato un output con le righe finali

```
--------------------------------------
       Local: http://localhost:81
    External: http://172.21.198.17:81
 --------------------------------------
          UI: http://localhost:3001
 UI External: http://172.21.198.17:3001
 --------------------------------------
 ```
il sistema monitora i cambiamenti dei file in
* src/scss
* src/js/
* *themePath*

il browser si apre sul dominio impostato nel file config.json
i file scss vengono compilati nel file themePath/style.css

Utilità:
resettare la versione locale alla versione remota
```
git fetch origin
git reset --hard origin/master
```

- [x] importare mixin e variabili da un progetto finito
- [x] sostituire storefront con versione standard da wpackagist
- [ ] automatizzare git remote
