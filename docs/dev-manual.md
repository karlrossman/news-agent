# Dev Manual (wp-env)

## Avvio e stato
```bash
npx wp-env start        # avvia o crea i container
npx wp-env --info       # mostra URL, porte, path montati
npx wp-env logs         # log live (Ctrl+C per uscire)
```

## Stop / Restart / Rebuild
```bash
npx wp-env stop         # ferma i container
npx wp-env start        # riavvia

# ricrea da zero (ATTENZIONE: cancella DB e volumi di wp-env)
npx wp-env destroy
npx wp-env start
```

> Nota: se hai installato wp-env globalmente puoi usare `wp-env` al posto di `npx wp-env`.

## WP-CLI
```bash
npx wp-env run cli wp core version
npx wp-env run cli wp plugin list
npx wp-env run cli wp option get siteurl
```

## Shell nel container
```bash
npx wp-env run cli bash   # esci con 'exit'
```

## Troubleshooting
- **404 / pagina non trovata**: controlla con `npx wp-env --info`, poi `npx wp-env logs`. Se persiste, esegui `npx wp-env destroy && npx wp-env start`.
- **Porte occupate**: cambia la porta in `.wp-env.json` o libera quella in conflitto.
- **Reset forte**: `destroy` elimina il DB e i volumi, quindi riparti pulito.
