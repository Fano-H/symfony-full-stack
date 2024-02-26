<?php

namespace App\Service;

use App\Entity\Account;
use App\Entity\Brand;
use App\Entity\Energy;
use App\Entity\EventOrigin;
use App\Entity\Model;
use App\Entity\Vehicle;
use App\Repository\AccountRepository;
use App\Repository\BrandRepository;
use App\Repository\EnergyRepository;
use App\Repository\EventOriginRepository;
use App\Repository\ModelRepository;
use App\Repository\VehicleRepository;
use Doctrine\ORM\EntityManagerInterface;
use PhpOffice\PhpSpreadsheet\IOFactory;

class SheetImport
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private AccountRepository $accountRepository,
        private VehicleRepository $vehicleRepository,
        private BrandRepository $brandRepository,
        private ModelRepository $modelRepository,
        private EnergyRepository $energyRepository,
        private EventOriginRepository $eventOriginRepository,
    )
    {
    }

    public function import(string $filepath)
    {
        $spreadsheet = IOFactory::load($filepath);
        $data = $spreadsheet->getSheet(0);
        $dataArray = $data->toArray();

        // for ($i=1; $i < count($dataArray) ; $i++) { 
        for ($i=1; $i < 2 ; $i++) { 
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

        $account = $this->handleAccount($businessAccount);
        $brand = $this->handleBrand($brandLabel);
        $model = $this->handleModel($modelLabel, $brand);
        $energy = $this->handleEnergy($energyLabel);
        $originEvent = $this->handleEventOrigin($eventOrigin);
        $eventAccount = $this->handleAccount($eventAccount);

        $vehicle = $this->handleVehicle(
            $vin,
            $registrationNo,
            new \DateTime($dateOfCirculation),
            $version,
            $mileAge,
            $brand,
            $model,
            $energy,
            $originEvent,
            $eventAccount
        );
        
    }

    private function saveInstance(object $instance): void{
        $this->entityManager->persist($instance);
        $this->entityManager->flush();
    }

    private function handleAccount(string $accountName): Account
    {
        $accountName = trim($accountName);
        $account = $this->accountRepository->findOneBy(["name" => $accountName]);
        
        if(!$account){
            $account = new Account();
            $account->setName($accountName);
            $this->saveInstance($account);
        }
        
        return $account;
    }

    private function handleVehicle(string $vin, string|null $registrationNo, \Datetime|null $dateOfCirculation, string|null $version, string|null $mileAge, Brand $brand, Model|null $model, Energy|null $energy, EventOrigin $eventOrigin, Account $eventAccount): Vehicle
    {
        $vin = trim($vin);
        $vehicle = $this->vehicleRepository->findOneBy(["vin" => $vin]);

        if(!$vehicle){
            $vehicle = new Vehicle();
            $vehicle->setVin($vin);
            $vehicle->setRegistrationNo($registrationNo);
            $vehicle->setDateOfCirculation($dateOfCirculation);
            $vehicle->setVersion($version);
            $vehicle->setMileAge($mileAge);
            $vehicle->setBrand($brand);
            $vehicle->setModel($model);
            $vehicle->setEnergy($energy);
            $vehicle->setOriginEvent($eventOrigin);
            $vehicle->setEventAccount($eventAccount);

            $this->saveInstance($vehicle);
        }

        return $vehicle;
    }

    private function handleBrand(string $name): Brand
    {
        $name = trim($name);
        $brand = $this->brandRepository->findOneBy(["name" => $name]);

        if(!$brand){
            $brand = new Brand();
            $brand->setName($name);
    
            $this->saveInstance($brand);
        }
        
        return $brand;
    }

    private function handleModel(string $name, Brand $brand): Model
    {
        $name = trim($name);
        $model = $this->modelRepository->findOneBy(["name" => $name, "brand" => $brand]);

        if(!$model)
        {
            $model = new Model();
            $model->setName($name);
            $model->setBrand($brand);
    
            $this->saveInstance($model);
        }
        
        return $model;
    }

    private function handleEnergy(string $label): Energy
    {
        $label = trim($label);
        $energy = $this->energyRepository->findOneBy(["label" => $label]);

        if(!$energy){
            $energy = new Energy();
            $energy->setLabel($label);

            $this->saveInstance($energy);
        }
        
        return $energy;
    }

    private function handleEventOrigin(string $label): EventOrigin
    {   
        $label = trim($label);
        $eventOrigin = $this->eventOriginRepository->findOneBy(["label" => $label]);

        if(!$eventOrigin)
        {
            $eventOrigin = new EventOrigin();
            $eventOrigin->setLabel($label);

            $this->saveInstance($eventOrigin);
        }
        return $eventOrigin;
    }

}   