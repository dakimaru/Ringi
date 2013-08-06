#! /bin/sh

unzip PHPExcel_1.7.9_doc.zip Classes/*
rm -rf ../app/Vendor/excel
mv Classes ../app/Vendor/excel
