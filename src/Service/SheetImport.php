<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use PhpOffice\PhpSpreadsheet\IOFactory;

class SheetImport
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    )
    {
    }

    public function import(string $filepath)
    {
        $spreadsheet = IOFactory::load($filepath);
        $data = $spreadsheet->getSheet(0);
        $dataArray = $data->toArray();

        for ($i=1; $i < count($dataArray) ; $i++) { 
            $row = $dataArray[$i];

            $businessAccount = $row[0];
            $eventAccount = $row[1];
            $lastEventAccount = $row[2];
            $recordFileNo = $row[3];
            $civilityLabel = $row[4];
            $currentVehicleOwner = $row[5];
            $lastName = $row[6];
            $firstName = $row[7];
            $trackNumberAndName = $row[8];
            $additionalAddress1 = $row[9];
            $postalCode = $row[10];
            $cityName = $row[11];
            $homePhone = $row[12];
            $cellPhone = $row[13];
            $jobPhone = $row[14];
            $email = $row[15];
            $dateOfCirculation = $row[16];
            $purchaseDate = $row[17];
            $lastEventDate = $row[18];
            $brandLabel = $row[19];
            $modelLabel = $row[20];
            $version = $row[21];
            $vin = $row[22];
            $registrationNo = $row[23];
            $prospectType = $row[24];
            $mileAge = $row[25];
            $energyLabel = $row[26];
            $vnSeller = $row[27];
            $voSeller = $row[28];
            $invoicingComment = $row[29];
            $vnVoType = $row[30];
            $vnVoFolderNo = $row[31];
            $saleIntermediary = $row[32];
            $eventDate = $row[33];
            $eventOrigin = $row[34];
            
        }
        
    }
}