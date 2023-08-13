#!/bin/bash

# Clean up previous build files
rm -rf build/
mkdir -p build/

# Copy necessary files to the build directory
cp -R app/ build/
cp -R bootstrap/ build/
cp -R config/ build/
cp -R database/ build/
cp -R public/ build/
cp -R resources/ build/
cp -R routes/ build/
cp -R storage/ build/
cp .env build/
cp artisan build/
cp composer.json build/
cp package.json build/

# Additional build steps (if required)
# Run any necessary commands for your specific project

# Example: Running Composer install
cd build/
#composer install --no-dev --optimize-autoloader

# Example: Running Artisan commands
#php artisan clear-compiled
#php artisan optimize

# Example: Running migrations (if needed)
#php artisan migrate --force

# Example: Generating optimized assets
#npm install --prefix build/
#npm run production --prefix build/

# Remove unnecessary files
#rm -rf build/.env

# Set appropriate file permissions (if required)
#chmod -R 755 build/

# Zip it up
zip -r project.zip .

# Verify the build was successful
if [ $? -eq 0 ]; then
  echo "Build completed successfully."
else
  echo "Build failed. Please check the build process."
  exit 1
fi
