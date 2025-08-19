# DEV-MANUAL.md

Manuale tecnico per lo sviluppo di **News 25 DEV**.  
Contiene istruzioni dettagliate su setup locale, Docker, architettura e troubleshooting.  

---

## 1) Requisiti di sistema
- **PHP** 8.2+
- **MySQL/MariaDB** 10.6+
- **Node.js** 20+ (per build JS/CSS, se necessario)
- **Composer** (per dipendenze PHP)
- **Docker + Docker Compose** (se si utilizza `wp-env`)

---

## 2) Setup locale senza Docker
1. Clona il repository:
   ```bash
   git clone https://github.com/<org>/news25-dev.git
   cd news25-dev
   ```
2. Configura WordPress in locale (XAMPP, MAMP, ecc.)  
3. Copia i file del tema child in `wp-content/themes/news25-dev/`  
4. Crea un file `.env.local` (non committare!) con le credenziali DB e chiavi segrete.  
5. Importa il database di sviluppo se fornito.

---

## 3) Setup con Docker (`wp-env`)
Il progetto supporta [wp-env](https://developer.wordpress.org/block-editor/reference-guides/packages/packages-env/).

### Comandi principali
```bash
# Avviare i container
npx wp-env start

# Fermare l’ambiente
npx wp-env stop

# Log dei container
npx wp-env logs

# Resettare l’ambiente
npx wp-env destroy
```

---

## 4) Struttura del progetto
```
/theme-child/        # Tema child News 25 DEV
/docs/               # Documentazione (manuali, roadmap)
.mu-plugins/         # Plugin custom obbligatori
/contributing.md     # Linee guida contributori
/dev-manual.md       # Manuale sviluppatori (questo file)
```

---

## 5) Standard di sviluppo
- **PHP/WordPress**
  - Segui gli standard di coding WP
  - Usa funzioni di sanificazione (`esc_*`, `wp_kses_post`)
  - Evita query pesanti nei loop

- **CSS**
  - Mobile-first
  - Classi descrittive (no abbreviazioni criptiche)
  - Evita `!important` se non strettamente necessario

- **JS**
  - Evita codice morto o `console.log` nei branch finali
  - Scrivi funzioni piccole e riutilizzabili

---

## 6) Flusso di lavoro Git
Per convenzioni di branch, commit e PR → vedi `CONTRIBUTING.md`.  
In sintesi:
- `develop` è il branch di lavoro
- Nuove feature su `feature/...`
- Bugfix minori su `fix/...`
- Hotfix urgenti su `hotfix/...`

---

## 7) Rilasci
1. Merge su `main` solo tramite Pull Request approvate  
2. Taggare la release:
   ```bash
   git tag v2.5.1
   git push origin v2.5.1
   ```
3. Aggiornare il changelog (`CHANGELOG.md` se presente)  
4. Creare release su GitHub con note e, opzionalmente, ZIP del tema/plugin  

---

## 8) Troubleshooting
- **Database non parte (Docker)** → prova `npx wp-env destroy && npx wp-env start`  
- **File mancanti** → controlla `.gitignore` (potresti dover copiare file `.env` manualmente)  
- **Dipendenze mancanti** → lancia `composer install` o `npm install` secondo il caso  
- **Permessi file** → su Linux/Mac, assicurati che `wp-content/uploads` sia scrivibile  

---

## 9) Risorse utili
- [Handbook WordPress](https://developer.wordpress.org/)  
- [WordPress Coding Standards](https://developer.wordpress.org/coding-standards/wordpress-coding-standards/)  
- [Docker Compose](https://docs.docker.com/compose/)  
- [Conventional Commits](https://www.conventionalcommits.org/)  

---

🙌 Buon lavoro e grazie per mantenere il progetto solido e ben documentato!
