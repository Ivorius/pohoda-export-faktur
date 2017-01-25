pohoda-export-faktur
====================

Export invoices to XML format used in accounting software POHODA

Třídy umožní importovat/exportovat faktury do stormware POHODA účetnictnictví. Není to kompletní převod, nezahrnuje to všehny parametry, ale umožňuje to generovat XML, základní validaci a hlásí to chyby. 
Je to něco co vzniklo jako utilitka v SECTION Technologies s.r.o. Další rozšíření a úpravy Mgr. Ivo Toman www.aivo.cz

## Quick Start

```php

require_once('Export.php');
require_once('Invoice.php');
require_once('InvoiceItem.php');
require_once('Validators.php');
//or use autoloader :)

// zadejte ICO
$pohoda = new Pohoda\Export('01508512');

// cislo faktury
$invoice = new Pohoda\Invoice(324342);

// cena faktury s DPH (po staru) - volitelně
$invoice->setText('faktura za prace ...');
$price = 1000;
$invoice->setPriceWithoutVAT($price);
$invoice->setPriceOnlyVAT($price*0.21);
$invoice->withVAT(true);

//nebo pridanim polozek do faktury (nove)
$invoice->setText('Faktura za zboží');
//polozky na fakture
$item = new Pohoda\InvoiceItem();
$item->setText("Název produktu");
$item->setQuantity(1); //pocet
$item->setCode("x230"); //katalogove cislo
$item->setUnit("ks"); //jednotka
$item->setNote("červená"); //poznamka
$item->setStockItem(230); //ID produktu v Pohode
//nastaveni ceny je volitelne, Pohoda si umi vytahnout cenu ze sve databaze pokud je nastaven stockItem
$item->setUnitPrice(1000); //cena
$item->setRateVAT($item::VAT_HIGH); //21%
$item->setPayVAT(false); //cena bez dph

$invoice->addItem($item);

// variabilni cislo
$invoice->setVariableNumber('12345678');
// datum vytvoreni faktury
$invoice->setDateCreated('2014-01-24');
// datum zdanitelneho plneni
$invoice->setDateTax('2014-02-01');
// datum splatnosti
$invoice->setDateDue('2014-02-04');
//datum vytvoreni objednavky
$invoice->setDateOrder('2014-01-24');

//cislo objednavky v eshopu
$invoice->setNumberOrder(254);

// nastaveni identity dodavatele
$invoice->setProviderIdentity([
    "company" => "Firma s.r.o.",
    "city" => "Praha",
    "street" => "Nejaka ulice",
    "number" => "80/3",
    "zip" => "160 00",
    "ico" => "034234",
    "dic" => "CZ034234"]);
    
// nastaveni identity prijemce
$invoice->setPurchaserIdentity([
    "company" => "Firma s.r.o.",
    "city" => "Praha",
    "street" => "Nejaka ulice 80/3",
    "zip" => "160 00",
    "ico" => "034234"]);
//muzeme take zadat jinou dorucovaci adresu
$invoice->setPurchaserIdentity([
	"name" => "Jarda Ferda",
    "city" => "Brno",
    "street" => "Jina ulice10",
    "zip" => "165 00"], $invoice::SHIPTO);
```

## Validace

```php

if ($invoice->isValid()) {
    // pokud je faktura validni, pridame ji do exportu
    $pohoda->setInvoice($invoice);
}
else {
    var_dump($invoice->getErrors());
}

```


## Export

```php

// ulozeni do souboru
$errorsNo = 0; // pokud si pocitate chyby, projevi se to v nazvu souboru
$pohoda->setExportFolder(__DIR__ . "/export/pohoda"); //mozno nastavit slozku, do ktere bude proveden export
$pohoda->exportToFile(time(), 'popis', date("Y-m-d_H-i-s"), $errorsNo);

// vypsani na obrazovku jako retezec
$pohoda->exportAsString(time(), 'popis', date("Y-m-d_H-i-s"));

// vypsani na obrazovku jako XML s hlavickou
$pohoda->exportAsXml(time(), 'popis', date("Y-m-d_H-i-s")



```
