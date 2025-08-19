# news 25 dev

Tema child per WordPress basato su BlankSlate per il progetto
**News Agent**.

Puoi contribuire scegliendo il tuo ambiente di sviluppo preferito, fornendo però versioni di softwares e server compatibili (vedi 'Versioni del software uata per lo sviluppo' più sotto).
Il progetto è sviluppato e mantenuto in ambiente Docker - wp-env.
---

## ambiente di sviluppo docker (wp-env) – consigliato
Avvia un’istanza WordPress locale con Docker in meno di un minuto.
Docker crea un contenitore software che ospita un WordPress pronto all’uso. Noi lo gestiamo tramite **wp-env**.

### 1. avvio con wp-env
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

### 2. consulta la documentazione tecnica
- [docs/dev-manual.md](./docs/dev-manual.md) – manuale per sviluppatori  
- [contributing.md](./contributing.md) – regole per contributori  
- [changelog.md](./changelog.md) – cronologia modifiche  

---

## installazione libera (xampp, mamp, wamp, hosting remoto, ecc.)
Questa opzione è adatta se hai già un WordPress installato o vuoi lavorare su hosting.

### Versioni del software uata per lo sviluppo
- PHP 8.2 (consigliato) o 8.1  
- MySQL 8.0 / MariaDB 10.6+  
- WordPress 6.6+  

### installazione
1. Installa WordPress come preferisci (locale o remoto).  
2. Copia i file del progetto:
   - `themes/news-25-dev` → `wp-content/themes/news-25-dev/`  
   - `plugins/news-agent` → `wp-content/plugins/news-agent/`  
3. Dal pannello WordPress attiva:
   - tema **News 25 DEV**  
   - plugin **News Agent**  

👉 Nota: `wp-env` è solo per comodità. Puoi ignorarlo se preferisci un altro stack.  

---

## roadmap
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
