# Magento 2 Module - SalableQty

Package name: `peterbrain/magento2-salable-qty`

- [Magento 2 Module - SalableQty](#magento-2-module---salableqty)
  - [Main Functionalities](#main-functionalities)
  - [Installation](#installation)
    - [Method 1: Composer (recommended)](#method-1-composer-recommended)
    - [Method 2: Zip file (not recommended)](#method-2-zip-file-not-recommended)
    - [Enable \& deploy](#enable--deploy)
  - [Usage](#usage)

## Main Functionalities

- Display a custom message about the salable quantity on the product detail page.
  - Customizable message: Only x item(s) left!
  - Customizable threshold
- Display custom message for products without salable quantity. This is the case if a product quantity equals 1 and is ordered, but is not yet shipped. The default behavior of Magento 2 is to display an error message that the requested quantity is no longer available after a click on the Add to cart button. Not ideal, because this can cause confusion as the product will continue to be displayed as "in stock" until it is shipped.
  - Option to disable the Add to cart button
  - Option to show a lock symbol on the Add to Cart button
  - Customizable message: This product has been sold recently and is no longer available.

Display custom message for products with salable quantity at or below threshold:
![Display custom message for products with salable quantity at or below threshold.](https://github.com/peterbrain/magento2-salable-qty/blob/media/salable-qty_frontend-threshold.jpg?raw=true)
Disable Add to cart button for products without salable quantity:
![Disable Add to cart button for products without salable quantity.](https://github.com/peterbrain/magento2-salable-qty/blob/media/salable-qty_frontend-disabled.jpg?raw=true)
Admin configuration:
![Admin configuration](https://github.com/peterbrain/magento2-salable-qty/blob/media/salable-qty_admin.jpg?raw=true)

## Installation

### Method 1: Composer (recommended)

```bash
composer require peterbrain/magento2-salable-qty
```

### Method 2: Zip file (not recommended)

- Unzip the zip file in `app/code/PeterBrain`

This extension requires [PeterBrain Core](https://github.com/PeterBrain/magento2-peterbrain-core). Ensure that you have it installed prior to installing this module. Use Composer to install it automatically with this module.

### Enable & deploy

```bash
bin/magento module:enable PeterBrain_SalableQty
bin/magento setup:upgrade
bin/magento setup:static-content:deploy
bin/magento cache:flush
```

## Usage

- Enable module output in `Stores > Configuration > PeterBrain Extensions > Salable Quantity > General Configuration`
- Set a custom message for products with salable quantity is zero
- Disable the add to cart button if salable quantity is zero
- Set a custom minimum  salable quantity threshold
- Set a custom message for salable product quantity at or below the custom threshold
