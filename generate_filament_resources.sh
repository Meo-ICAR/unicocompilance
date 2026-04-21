#!/bin/bash

# List of COMPILANCE models
MODELS=(
    "COMPILANCE\\CompanyBranch"
)

# Generate resources for remaining models
for model in "${MODELS[@]}"; do
    echo "Generating resource for $model..."
    php artisan make:filament-resource "$model" --generate --no-interaction
done
