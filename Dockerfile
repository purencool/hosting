# --- Stage 1: Build Composer Dependencies ---
FROM composer:2.7 AS composer

WORKDIR /app

# Copy only composer files for caching
COPY composer.json composer.lock ./

RUN composer install --no-scripts --no-autoloader --prefer-dist --no-dev

# Copy the rest of the application
COPY . .

RUN composer dump-autoload --optimize

# --- Stage 2: For the future when rest api is completed ---
#FROM node:20 AS node

#WORKDIR /app

#COPY package.json package-lock.json ./
#RUN npm ci

#COPY . .
#RUN npm run build

# --- Stage 3: Final Image ---
FROM php:8.2-cli-alpine

# Install system dependencies (including bash)
RUN apk add --no-cache bash unzip 

WORKDIR /var/www

# Copy PHP dependencies from composer stage
COPY --from=composer /app ./

# Copy built assets from node stage (if applicable)
#COPY --from=node /app/public/build ./public/build

# Install Laravel CLI dependencies (if needed)
# RUN php artisan key:generate

# Expose port (if running via php -S or similar)
EXPOSE 8000

# Default command (bash for interactive, or entrypoint for production)
CMD ["/bin/bash"]