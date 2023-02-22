# Magento 2 Module - Salable Quantity

Package name: `peterbrain/magento2-salable-qty`

- [Magento 2 Module - SalableQty](#magento-2-module---salable-quantity)
  - [Main Functionalities](#main-functionalities)
  - [Installation](#installation)
    - [Method 1: Composer (recommended)](#method-1-composer-recommended)
    - [Method 2: Zip file (not recommended)](#method-2-zip-file-not-recommended)
    - [Enable & deploy](#enable--deploy)
  - [Usage](#usage)

## Main Functionalities

- Display a custom message about the salable quantity on the product detail page.
  - Customizable message: Only x item(s) left!
  - Customizable threshold
- Display custom message for products without salable quantity. This is the case if a product quantity equals 1 and is ordered, but is not yet shipped. The default behavior of Magento is to display an error message that the requested quantity is no longer available after a click on the Add to cart button. Not ideal, because this can cause confusion as the product will continue to be displayed as "in stock" until it is shipped.
  - Option to disable the Add to cart button
  - Custmizable message: This product has been sold recently and is no longer available.

## Installation

### Method 1: Composer (recommended)

```bash
composer require peterbrain/magento2-salable-qty
```

### Method 2: Zip file (not recommended)

- Unzip the zip file in `app/code/PeterBrain`

This extension is depend on [PeterBrain Core](https://github.com/PeterBrain/magento2-peterbrain-core). Make sure that you have installed it first. Use composer to install it automatically with this module.

### Enable & deploy

```bash
php bin/magento module:enable PeterBrain_SalableQty
php bin/magento setup:upgrade
php bin/magento cache:flush
```

## Usage

- Enable module ouptut in `Stores > Configuration > PeterBrain Extensions > Salable Quantity > General Configuration`
- Set a custom message for products with salable quantity is zero
- Disable the add to cart button if salable quantity is zero
- Set a custom minimum  salable quantity threshold
- Set a custom message for salable product quantity at or below the custom threshold
