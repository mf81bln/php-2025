# Mezzio Kontakt-Datenbank

Eine moderne Kontakt-Datenbank-Anwendung basierend auf **Mezzio** (PSR-15 Middleware) mit **PHP 8.5** und PostgreSQL.

## PHP State 2025/2026

Dieses Projekt nutzt die neuesten PHP-Features:

- **PHP 8.5** - Mit Pipe Operator (`|>`), neue URI Extension, Fatal Error Backtraces
- **Mezzio** - Modernes PSR-15 Middleware Framework (Nachfolger von Laminas MVC)
- **2025**: 30 Jahre PHP!

### Warum Mezzio statt Laminas MVC?

Laminas MVC wurde im Juni 2025 als "security-only" markiert und nach PHP 8.5 Release als "abandoned" eingestuft. Mezzio ist der offizielle Nachfolger und bietet:

- PSR-15 Middleware-Architektur
- Bessere Testbarkeit
- Weniger Framework-Kopplung
- Bessere Performance

## Schnellstart

### Mit Docker (empfohlen)

```bash
# Container starten
docker-compose up -d

# Warten bis die Datenbank bereit ist (ca. 10-15 Sekunden)
# Dann die Anwendung öffnen:
# http://localhost:8080/contact
```

Das war's! Die Datenbank wird automatisch initialisiert mit Beispielkontakten.

### Container stoppen

```bash
docker-compose down

# Oder mit Löschung der Datenbank-Daten:
docker-compose down -v
```

## Funktionen

- **Kontakte anzeigen** - Liste aller Kontakte
- **Kontakt anlegen** - Neuen Kontakt erstellen
- **Kontakt bearbeiten** - Bestehende Kontaktdaten aktualisieren
- **Kontakt löschen** - Kontakt mit Bestätigung entfernen

## Technologie-Stack

| Komponente | Technologie |
|------------|-------------|
| Framework | **Mezzio 3.x** (PSR-15) |
| PHP Version | **8.5** |
| Datenbank | PostgreSQL 16 |
| Template Engine | Laminas View |
| Container | Docker + docker-compose |
| CSS | Bootstrap 5 (CDN) |

## Projektstruktur

```
├── docker-compose.yml      # Docker-Konfiguration
├── Dockerfile              # PHP 8.5/Apache Container
├── docker/
│   └── init.sql            # Datenbank-Initialisierung
├── config/
│   ├── routes.php          # Routen-Definition
│   └── autoload/
│       └── db.global.php   # Datenbank-Konfiguration
├── src/App/
│   ├── ConfigProvider.php  # DI-Konfiguration
│   ├── Handler/
│   │   └── Contact/        # Contact Handler (CRUD)
│   │       ├── ListHandler.php
│   │       ├── CreateHandler.php
│   │       ├── EditHandler.php
│   │       └── DeleteHandler.php
│   └── Model/
│       ├── Contact.php     # Entity
│       └── ContactTable.php # TableGateway
└── templates/
    ├── layout/default.phtml
    └── app/contact/        # Contact Views
        ├── list.phtml
        ├── create.phtml
        ├── edit.phtml
        └── delete.phtml
```

## Entwicklung

### Lokale Entwicklung ohne Docker

1. PHP 8.5+ und PostgreSQL installieren
2. Datenbank erstellen:
   ```sql
   CREATE DATABASE contacts;
   CREATE USER laminas WITH PASSWORD 'laminas_secret';
   GRANT ALL PRIVILEGES ON DATABASE contacts TO laminas;
   ```
3. Init-Script ausführen: `psql -U laminas -d contacts -f docker/init.sql`
4. Dependencies installieren: `composer install --ignore-platform-reqs`
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

## API Endpoints

| Route | Methode | Handler | Beschreibung |
|-------|---------|---------|--------------|
| `/contact` | GET | ListHandler | Kontaktliste |
| `/contact/create` | GET/POST | CreateHandler | Neuer Kontakt |
| `/contact/edit/{id}` | GET/POST | EditHandler | Kontakt bearbeiten |
| `/contact/delete/{id}` | GET/POST | DeleteHandler | Kontakt löschen |

## Lizenz

BSD-3-Clause
