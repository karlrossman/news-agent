# CONTRIBUTING.md

Grazie per il tuo contributo a **News 25 DEV**!  
Questo documento spiega come collaborare in modo efficace: branch, commit, pull request, regole di stile e rilasci.  

---

## 0) Prerequisiti
- Git installato e un account GitHub attivo  
- WordPress locale **oppure** ambiente Docker (`wp-env`)  
- Lettura preliminare di **README.md**, **dev-manual.md**, **roadmap.md**

---

## 1) Workflow Git (branch model)
- **main** → rilasci stabili (solo merge via PR approvate)  
- **develop** → integrazione continua (base per nuove feature)  
- **feature/*** → nuove funzionalità (es. `feature/burger-menu`)  
- **fix/*** → bugfix non critici (es. `fix/mobile-header`)  
- **hotfix/*** → correzioni urgenti da rilasciare subito su `main`  

### Creare una feature branch
```bash
git checkout develop
git pull
git checkout -b feature/nome-funzionalita
# ... sviluppo ...
git add <file>
git commit -m "feat: breve descrizione"
git push -u origin feature/nome-funzionalita
```

---

## 2) Commit message (Conventional Commits)
Formato: **`<type>: <descrizione>`**

Tipi principali:  
- `feat:` nuova funzionalità  
- `fix:` correzione bug  
- `docs:` documentazione  
- `style:` formattazione (senza cambi logici)  
- `refactor:` refactoring senza modifiche funzionali  
- `perf:` miglioramento prestazioni  
- `test:` test e fixture  
- `chore:` manutenzione, build, toolchain  

Esempi:
```text
feat: aggiunge burger menu responsive
fix: corregge z-index submenu su mobile
docs: aggiorna dev manual con wp-env logs
```

Suggerimenti:  
- Frasi brevi, al presente  
- Un commit = una modifica coerente  

---

## 3) Pull Request (PR)
1. Apri una PR da `feature/...` verso `develop`  
   (oppure da `hotfix/...` verso `main` se urgente).  
2. Compila la descrizione con:
   - Scopo e contesto  
   - Cosa cambia  
   - Come testare (passi riproducibili)  
   - Eventuali issue collegate (`Closes #NN`)  
3. Checklist prima della review:
   - [ ] Lint/format ok (se configurati)  
   - [ ] Test manuali su desktop e mobile  
   - [ ] Nessun file superfluo (zip, build locali, ecc.)  
   - [ ] Documentazione aggiornata  
4. Richiedi review a un maintainer  
5. Dopo approvazione → **Squash & Merge**  

> PR verso `main` devono essere piccole, mirate e collegate a release note.

---

## 4) Stile del codice (linee guida rapide)
- **PHP/WordPress**: standard WP, funzioni `esc_*`, i18n  
- **CSS**: classi descrittive, evita `!important`, mobile-first  
- **JS**: funzioni piccole, niente `console.log` in PR finali  
- **Sicurezza**: sanificazione output (`esc_html`, `esc_attr`, `wp_kses_post`), nonce nei form  
- **Prestazioni**: asset caricati condizionalmente, query leggere  

---

## 5) Issue, label e milestone
- Issue chiare: **titolo breve**, passi per riprodurre, atteso vs ottenuto  
- Label disponibili: `bug`, `enhancement`, `docs`, `good first issue`, `priority:high`  
- Collega sempre a una milestone se fa parte di un rilascio  

---

## 6) Ambiente di sviluppo
- **Senza Docker**: PHP 8.2 + MySQL/MariaDB  
- **Con Docker**: vedi istruzioni in `dev-manual.md` (`wp-env start`, `stop`, `logs`, `destroy`)  
- Non committare file locali: `.env`, configurazioni IDE, build  

---

## 7) Rilasci (maintainer)
- Tag su `main` (es. `v2.5.1`)  
- Changelog sintetico  
- (Opzionale) Allegare ZIP di tema e plugin per utenti non-Docker  

---

## 8) Comandi Git essenziali
Per chi inizia, ecco i comandi più usati:  

```bash
# Controlla lo stato dei file e del branch
git status  

# Aggiungi file singoli o tutti i file nuovi/modificati
git add nomefile.ext
git add .  

# Crea un commit con messaggio descrittivo
git commit -m "feat: descrizione"  

# Invia i commit al branch remoto
git push origin nome-branch  

# Aggiorna il branch locale
git pull origin nome-branch  

# Passa a un altro branch
git checkout nome-branch  

# Crea un nuovo branch
git checkout -b nome-branch  

# Unisci un branch in quello attivo
git merge nome-branch  
```

---

🙌 Grazie per contribuire e mantenere il progetto ordinato e accessibile!
