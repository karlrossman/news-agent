# CONTRIBUTING.md

Grazie per il tuo contributo a **News 25 DEV**! Questo documento spiega come collaborare in modo efficace (branch, commit, PR).

## 0) Prerequisiti
- Git e un account GitHub
- WordPress locale **oppure** ambiente Docker (wp-env) – a scelta
- Leggi **README.md**, **dev-manual.md**, **roadmap.md**

---

## 1) Workflow Git (branch model)
- **main** → rilasci stabili (solo merge via PR)
- **develop** → integrazione continua (base per nuove feature)
- **feature/*** → sviluppo di funzionalità (es. `feature/burger-menu`)
- **fix/*** → bugfix non critici (es. `fix/mobile-header`)
- **hotfix/*** → bugfix urgenti da rilasciare su `main`

### Creare una feature branch
```bash
git checkout develop
git pull
git checkout -b feature/nome-funzionalita
# ...sviluppo...
git add <file>
git commit -m "feat: breve descrizione"
git push -u origin feature/nome-funzionalita
```

---

## 2) Commit message (Conventional Commits)
Usa il formato: **`<type>: <descrizione>`**
- `feat:` nuova funzionalità
- `fix:` correzione bug
- `docs:` documentazione
- `style:` formattazione (no cambi logica)
- `refactor:` refactor senza cambi funzionali
- `perf:` performance
- `test:` test e fixture
- `chore:` manutenzione, build, toolchain

Esempi:
```text
feat: aggiunge burger menu responsive
fix: corregge z-index submenu su mobile
docs: aggiorna dev manual con wp-env logs
```

Suggerimenti:
- Scrivi frasi brevi al presente
- Un commit → un’idea/coerenza

---

## 3) Pull Request (PR)
1. **Apri una PR** da `feature/...` verso `develop` (o `hotfix/...` verso `main` se urgente)
2. Compila la descrizione con:
   - Scopo/contesto
   - Cosa cambia
   - Come testare (passi riproducibili)
   - Issue collegata (`Closes #NN`)
3. **Checklist** prima di richiedere review:
   - [ ] Lint/format ok (se configurati)
   - [ ] Test manuali su desktop e mobile
   - [ ] Nessun file superfluo (niente zip, build locali, ecc.)
   - [ ] Documentazione aggiornata (README/roadmap se serve)
4. Richiedi review a un maintainer
5. Dopo approvazione → **Squash & Merge** (mantiene storia pulita)

> Le PR su `main` devono essere piccole, mirate e collegate a release note.

---

## 4) Stile del codice (linee guida rapide)
- **PHP/WordPress**: segui gli standard WP (underscore in hooks, esc_* dove serve, i18n)
- **CSS**: classi descrittive, evita !important, mobile-first quando possibile
- **JS**: funzioni piccole, nessun codice morto/console.log in PR finali
- **Sicurezza**: sanifica output (`esc_html`, `esc_attr`, `wp_kses_post`), nonce nei form
- **Prestazioni**: carica asset condizionalmente, evita query pesanti in loop

---

## 5) Issue, label e milestone
- Apri issue chiare: **titolo breve** + **passi per riprodurre** + **atteso vs ottenuto**
- Usa label (`bug`, `enhancement`, `docs`, `good first issue`, `priority:high`)
- Collega a una **milestone** se la modifica fa parte di un rilascio

---

## 6) Ambiente di sviluppo
- **Senza Docker**: usa PHP 8.2 + MySQL/MariaDB raccomandati nel README
- **Con Docker**: vedi `wp-env` in `dev-manual.md` (start/stop/logs/destroy)
- Non committare file di ambiente locali: `.env` sensibili, configurazioni IDE, build

---

## 7) Rilasci (maintainer)
- Taggare release su `main` (es. `v2.5.1`)
- Changelog sintetico
- (Opz.) Allegare ZIP **tema** e **plugin** per chi non usa Docker

---

Grazie per mantenere il progetto ordinato e accessibile! 🙌
