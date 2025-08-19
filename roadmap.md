# Roadmap - Progetto News 25 DEV

## Stato attuale
- Ambiente di sviluppo con **wp-env** (Docker) operativo.
- WordPress installato.
- Tema child attivo: **News 25 DEV**.
- Plugin custom **news-agent** installato.
- Repo GitHub privato attivo.
- Branch: `main`, `develop`.

## Prossimi step

### A) Versionamento (GitHub)
- [ ] Verificare remote `origin` sulla repo privata.
- [ ] Aggiornare `.gitignore` (node_modules, .wp-env, vendor, cache, ecc.).
- [ ] Commit iniziali documentazione (README, roadmap, dev-manual).
- [ ] Workflow: sviluppare su `develop`, merge in `main` per release.

### B) Popolamento contenuti
- [ ] Tassonomie/categorie iniziali.
- [ ] Articoli demo.
- [ ] Menu principale + burger menu responsive.
- [ ] Pagine base (Chi siamo, Contatti, Privacy).
- [ ] Verifica layout su mobile/desktop.

### C) Tecnico
- [ ] Backup DB (script WP-CLI).
- [ ] Script `npm` di comodo per `wp-env` (start/stop/logs).
- [ ] Documentazione minima aggiornata.

### D) Futuro
- [ ] Integrazione feed news / API.
- [ ] Performance (cache, immagini).
- [ ] Staging remoto / deploy.

## Log attività
- **15/08/2025**: setup iniziale wp-env, tema child, plugin news-agent.
- **17/08/2025**: riavvio ambiente, verifica Docker.
- **17/08/2025**: aggiunti README, dev-manual, roadmap.
