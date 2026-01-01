# Laminas Kontakt-Datenbank

Eine Kontakt-Datenbank-Anwendung basierend auf dem Laminas MVC Framework mit PostgreSQL.

## PHP State 2025/2026

Dieses Projekt wurde erstellt, um den aktuellen Stand von PHP zu erkunden:

- **PHP 8.4** (aktuell) - Mit Property Hooks, Asymmetric Visibility, Lazy Objects
- **PHP 8.5** (November 2025) - Mit Pipe Operator (`|>`), neue URI Extension, Fatal Error Backtraces
- **2025**: 30 Jahre PHP!

## Schnellstart

### Mit Docker (empfohlen)

```bash
# Container starten
docker-compose up -d

# Warten bis die Datenbank bereit ist (ca. 10-15 Sekunden)
# Dann die Anwendung öffnen:
# http://localhost:8080/contact
```

Das war's! Die Datenbank wird automatisch initialisiert mit ein paar Beispielkontakten.

### Container stoppen

```bash
docker-compose down

# Oder mit Löschung der Datenbank-Daten:
docker-compose down -v
```

## Funktionen

- **Kontakte anzeigen** - Liste aller Kontakte mit Suchfunktion
- **Kontakt anlegen** - Neuen Kontakt mit Name, E-Mail, Telefon und Notizen erstellen
- **Kontakt bearbeiten** - Bestehende Kontaktdaten aktualisieren
- **Kontakt löschen** - Kontakt mit Bestätigung entfernen

## Technologie-Stack

| Komponente | Technologie |
|------------|-------------|
| Framework | Laminas MVC |
| PHP Version | 8.4 |
| Datenbank | PostgreSQL 16 |
| Container | Docker + docker-compose |
| CSS | Bootstrap 5 |

## Projektstruktur

```
├── docker-compose.yml      # Docker-Konfiguration
├── Dockerfile              # PHP/Apache Container
├── docker/
│   └── init.sql            # Datenbank-Initialisierung
├── config/
│   ├── modules.config.php  # Module-Registrierung
│   └── autoload/
│       └── db.global.php   # Datenbank-Konfiguration
└── module/
    └── Contact/
        ├── config/
        │   └── module.config.php
        ├── src/
        │   ├── Controller/ContactController.php
        │   ├── Form/ContactForm.php
        │   ├── Model/Contact.php
        │   ├── Model/ContactTable.php
        │   └── Module.php
        └── view/
            └── contact/contact/
                ├── index.phtml
                ├── add.phtml
                ├── edit.phtml
                └── delete.phtml
```

## Entwicklung

### Lokale Entwicklung ohne Docker

1. PHP 8.1+ und PostgreSQL installieren
2. Datenbank erstellen:
   ```sql
   CREATE DATABASE contacts;
   CREATE USER laminas WITH PASSWORD 'laminas_secret';
   GRANT ALL PRIVILEGES ON DATABASE contacts TO laminas;
   ```
3. Init-Script ausführen: `psql -U laminas -d contacts -f docker/init.sql`
4. Dependencies installieren: `composer install`
5. Server starten: `composer serve`
6. Öffnen: http://localhost:8080/contact

### Environment-Variablen

| Variable | Standard | Beschreibung |
|----------|----------|--------------|
| DB_HOST | db | PostgreSQL Host |
| DB_PORT | 5432 | PostgreSQL Port |
| DB_NAME | contacts | Datenbankname |
| DB_USER | laminas | Benutzername |
| DB_PASSWORD | laminas_secret | Passwort |

## Lizenz

BSD-3-Clause
