import csv
import time
import re
from collections import deque
from urllib.parse import urljoin, urlparse, urldefrag
import os

import requests
from bs4 import BeautifulSoup
from requests.adapters import HTTPAdapter, Retry
import urllib.robotparser as robotparser

BASE_URL = "https://www.macplastsrl.it/it/"
OUTPUT_CSV = "prodotti_macplast.csv"
MAX_PAGES = 5000

# escludi asset
RE_EXCLUDE_EXT = re.compile(
    r".*\.(jpg|jpeg|png|gif|webp|svg|ico|css|js|pdf|zip|rar|7z|mp4|mp3|mov|avi|wmv|mkv)$",
    re.IGNORECASE
)

# fallback per SKU: cerca "Articolo: 123" o "Articolo 123"
RE_ARTICOLO = re.compile(r"\bArticolo[:\s]*([A-Za-z0-9\-_.]+)\b", re.IGNORECASE)

def make_session():
    s = requests.Session()
    retries = Retry(
        total=3,
        backoff_factor=0.5,
        status_forcelist=[429, 500, 502, 503, 504],
        allowed_methods=["GET", "HEAD"]
    )
    s.headers.update({
        "User-Agent": "Mozilla/5.0 (compatible; MacplastCrawler/1.3)"
    })
    s.mount("http://", HTTPAdapter(max_retries=retries))
    s.mount("https://", HTTPAdapter(max_retries=retries))
    return s

def same_section(url: str) -> bool:
    try:
        p = urlparse(url)
        if p.scheme not in ("http", "https"):
            return False
        base = urlparse(BASE_URL)
        if p.netloc != base.netloc:
            return False
        return p.path.startswith(base.path)
    except Exception:
        return False

def normalize_url(url: str) -> str:
    url, _ = urldefrag(url)
    return url

def is_crawlable(url: str, rp: robotparser.RobotFileParser) -> bool:
    if not same_section(url):
        return False
    if RE_EXCLUDE_EXT.match(url):
        return False
    try:
        return rp.can_fetch("*", url)
    except Exception:
        return True

def text_or_empty(el):
    return el.get_text(" ", strip=True) if el else ""

def filename_stem_from_url(u: str) -> str:
    try:
        path = urlparse(u).path
        base = os.path.basename(path)  # es. icog.png
        stem, _ = os.path.splitext(base)  # icog
        return stem
    except Exception:
        return ""

def html_or_empty(el):
    """Ritorna l'innerHTML dell'elemento (stringa), oppure stringa vuota."""
    try:
        return el.decode_contents().strip() if el else ""
    except Exception:
        return ""

def extract_sku(soup: BeautifulSoup) -> str:
    """
    Regole:
      1) qualsiasi elemento con [itemprop="sku"]
         - se ha attributo 'content', usa quello
         - altrimenti usa il testo dell'elemento
      2) se vuoto, cerca meta[itemprop="sku"][content]
      3) fallback: regex "Articolo 123" nel blocco centrale/body
    """
    el = soup.select_one('[itemprop="sku"]')
    if el:
        # preferisci l'attributo "content" se presente
        content_attr = (el.get("content") or "").strip()
        if content_attr:
            return content_attr
        # fallback al testo interno
        txt = el.get_text(strip=True)
        if txt:
            return txt

    # meta[itemprop="sku"]
    meta = soup.select_one('meta[itemprop="sku"][content]')
    if meta and meta.has_attr("content"):
        meta_val = meta["content"].strip()
        if meta_val:
            return meta_val

    # regex fallback (es. "Articolo 216")
    region_text = " ".join([
        text_or_empty(soup.select_one("#center_column")) or "",
        text_or_empty(soup.select_one("body"))
    ])
    m = RE_ARTICOLO.search(region_text)
    if m:
        return m.group(1).strip()

    return ""

def extract_fields(html: str, base_url_for_links: str):
    soup = BeautifulSoup(html, "html.parser")

    # Nome
    nome = text_or_empty(soup.select_one('h1[itemprop="name"]'))

    # SKU robusto
    sku = extract_sku(soup)

    # descrizione
    descrizione = text_or_empty(soup.select_one('div[itemprop="description"]'))

    # pressione
    pressione = text_or_empty(soup.select_one("div.txtpress"))

    # SDR
    sdr = text_or_empty(soup.select_one("div.sdr"))

    # categoria (icone in div.icoapplicazioni img[src] -> solo nome file .png senza estensione)
    categorie = []
    for img in soup.select("div.icoapplicazioni img[src]"):
        src = (img.get("src") or "").strip()
        if not src:
            continue
        abs_src = urljoin(base_url_for_links, src)
        stem = filename_stem_from_url(abs_src)
        if stem and stem not in categorie:
            categorie.append(stem)
    categoria = "|".join(categorie)

    # IMMAGINI (tutti gli href di a.fancybox)
    immagini = []
    for a in soup.select('a.fancybox[href]'):
        href = (a.get("href") or "").strip()
        if not href:
            continue
        abs_href = urljoin(base_url_for_links, href)
        if abs_href not in immagini:
            immagini.append(abs_href)
    immagini_str = "|".join(immagini)

    # SCHEDA DATI: innerHTML di <section id="tab3">
    scheda_dati = html_or_empty(soup.select_one('section#tab3'))

    # INFO TECNICHE: innerHTML di <section id="tabnote">
    info_tecniche = html_or_empty(soup.select_one('section#tabnote'))

    return {
        "Nome": nome,
        "SKU": sku,
        "descrizione": descrizione,
        "pressione": pressione,
        "SDR": sdr,
        "categoria": categoria,
        "IMMAGINI": immagini_str,
        "SCHEDA DATI": scheda_dati,
        "INFO TECNICHE": info_tecniche,
    }

def crawl():
    session = make_session()

    # robots.txt
    rp = robotparser.RobotFileParser()
    try:
        rp.set_url(urljoin(BASE_URL, "/robots.txt"))
        rp.read()
    except Exception:
        pass

    visited = set()
    queue = deque([BASE_URL])
    results = []
    pages_count = 0

    while queue and pages_count < MAX_PAGES:
        url = normalize_url(queue.popleft())
        if url in visited:
            continue
        visited.add(url)

        if not is_crawlable(url, rp):
            continue

        try:
            resp = session.get(url, timeout=20)
        except requests.RequestException:
            continue

        ctype = resp.headers.get("Content-Type", "")
        if resp.status_code != 200 or "text/html" not in ctype:
            continue

        pages_count += 1
        html = resp.text

        data = extract_fields(html, url)

        # Scrivi riga se la pagina contiene almeno uno dei valori richiesti
        if any(data.values()):
            results.append(data)

        # Estrazione link interni per proseguire
        try:
            soup = BeautifulSoup(html, "html.parser")
            for a in soup.find_all("a", href=True):
                href = a["href"].strip()
                if href.startswith(("mailto:", "tel:", "javascript:", "data:")):
                    continue
                next_url = normalize_url(urljoin(url, href))
                if same_section(next_url) and next_url not in visited and not RE_EXCLUDE_EXT.match(next_url):
                    queue.append(next_url)
        except Exception:
            pass

        time.sleep(0.25)  # gentilezza

    # Scrivi CSV finale
    fieldnames = [
        "Nome", "SKU", "descrizione", "pressione", "SDR",
        "categoria", "IMMAGINI", "SCHEDA DATI", "INFO TECNICHE"
    ]
    with open(OUTPUT_CSV, "w", newline="", encoding="utf-8-sig") as f:
        w = csv.DictWriter(f, fieldnames=fieldnames)
        w.writeheader()
        w.writerows(results)

    print(f"Fatto! Pagine esplorate: {pages_count}. Righe CSV: {len(results)}. File: {OUTPUT_CSV}")

if __name__ == "__main__":
    crawl()
