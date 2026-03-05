# Usa PHP CLI 8.2 come base
FROM php:8.2-cli

# Imposta la directory di lavoro
WORKDIR /app

# Copia i file iniziali
COPY . .

# Espone la porta 8000 (il server interno di PHP)
EXPOSE 8000

# Avvia il server interno PHP
CMD ["php", "-S", "0.0.0.0:8000", "-t", "."]