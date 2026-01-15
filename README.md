![Sheller Logo](public/logo.png)

# Sheller

![CI Status](https://github.com/tekk/sheller/actions/workflows/ci.yml/badge.svg)
![Latest Release](https://img.shields.io/github/v/release/tekk/sheller)
![License](https://img.shields.io/github/license/tekk/sheller)

**Sheller** is a nerdy, self-hostable command alias manager. Define complex shell commands with variables and execute them instantly via `curl` from any terminal.

## No-Bullshit Features
- **Write Once, Run Everywhere**: `curl domain.com/alias | bash`
- **Multi-OS**: Bash (Linux), Zsh (macOS), PowerShell (Windows).
- **Variables**: Dynamic injection via query params `?var=value`.
- **Advanced Editor**: Monaco Editor (VSCode) integration for syntax highlighting.
- **SSO**: Built-in Supabase Auth (GitHub/Email).
- **Drag-and-Drop Hosting**: Optimized for shared hosting (cPanel).
- **Zero-Config Installer**: Automated 3-step setup wizard.

## Quick Start

### Self-Hosting (Docker/Local)
```bash
composer install
php artisan key:generate
php artisan migrate
php artisan serve
```

### Shared Hosting
1. Upload files to your hosting root directory.
2. Visit website to run the Installer Wizard.
3. Done.

## Requirements
- PHP 8.2+
- MySQL or SQLite
- Supabase Project (for Auth)
