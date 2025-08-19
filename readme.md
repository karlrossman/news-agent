# News 25 DEV

Tema child per WordPress basato su BlankSlate per il progetto **News Agent**.  
Puoi contribuire scegliendo tra due opzioni di sviluppo.

## Ambiente di sviluppo Docker (wp-env) – consigliato
Avvia un’istanza WordPress locale con Docker in meno di un minuto.

Docker crea un contenitore software che ospita un WordPress pronto all’uso. Noi lo gestiamo tramite **wp-env**.

### 1. Avvio con wp-env
```bash
# avvio ambiente
npx wp-env start

# verifica info (URL e porte attive)
npx wp-env --info
```

WordPress sarà disponibile su:
- http://localhost:8888 (dev)
- http://localhost:8889 (test)

Credenziali predefinite:
- utente: `admin`
- password: `password`

Altri comandi utili:
```bash
npx wp-env logs
npx wp-env stop
npx wp-env destroy   # resetta l’ambiente (ATTENZIONE: cancella DB)
```

### 2. Consulta la documentazione tecnica
Leggi [docs/dev-manual.md](./docs/dev-manual.md) per maggiori dettagli.

---

## Installazione libera (XAMPP, MAMP, WAMP, hosting remoto, ecc.)
Questa opzione è adatta se hai già un WordPress installato o vuoi lavorare su hosting.

### Requisiti minimi
- PHP 8.2 (consigliato) o 8.1
- MySQL 8.0 / MariaDB 10.6+
- WordPress 6.6+

### Installazione
1. Installa WordPress come preferisci (locale o remoto).
2. Copia i file del progetto:
   - `themes/news-25-dev` → `wp-content/themes/news-25-dev/`
   - `plugins/news-agent` → `wp-content/plugins/news-agent/`
3. Dal pannello WordPress attiva:
   - tema **News 25 DEV**
   - plugin **News Agent**

👉 Nota: `wp-env` è solo per comodità. Puoi ignorarlo se preferisci un altro stack.

---

## Roadmap
Consulta [roadmap.md](./roadmap.md) per lo stato del progetto e i prossimi step.

---

## .gitignore

```gitignore
# Node / build
node_modules/
npm-debug.log*

# wp-env
docker-compose.override.yml
.wp-env/
.wp-env.json.tmp
wordpress-develop/

# Composer
vendor/
composer.lock

# Sistema operativo
.DS_Store
Thumbs.db

# Log e cache
*.log
*.cache

# Editor/IDE
.vscode/
.idea/
*.swp
```
