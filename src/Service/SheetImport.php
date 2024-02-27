<?php

namespace App\Service;

use App\Entity\City;
use App\Entity\Brand;
use App\Entity\Model;
use App\Entity\Energy;
use App\Entity\Seller;
use App\Entity\Account;
use App\Entity\Vehicle;
use App\Entity\Civility;
use App\Entity\SaleType;
use App\Entity\RecordFile;
use App\Entity\EventOrigin;
use App\Entity\EventVehicle;
use App\Entity\ProspectType;
use App\Repository\CityRepository;
use App\Repository\BrandRepository;
use App\Repository\ModelRepository;
use App\Repository\EnergyRepository;
use App\Repository\SellerRepository;
use App\Repository\AccountRepository;
use App\Repository\VehicleRepository;
use App\Repository\CivilityRepository;
use App\Repository\SaleTypeRepository;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Repository\RecordFileRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\EventOriginRepository;
use App\Repository\EventVehicleRepository;
use App\Repository\ProspectTypeRepository;

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
        private RecordFileRepository $recordFileRepository,
        private CivilityRepository $civilityRepository,
        private CityRepository $cityRepository,
        private SaleTypeRepository $saleTypeRepository,
        private SellerRepository $sellerRepository,
        private ProspectTypeRepository $prospectTypeRepository,
        private EventVehicleRepository $eventVehicleRepository,
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
            
            // Insert data
            
            $businessAccount = $this->handleAccount($businessAccount);
            $brand = $this->handleBrand($brandLabel);
            $model = $this->handleModel($modelLabel, $brand);
            $energy = $this->handleEnergy($energyLabel);
            $originEvent = $this->handleEventOrigin($eventOrigin);
            $eventAccount = $this->handleAccount($eventAccount);
            $lastEventAccount = $this->handleAccount($lastEventAccount);

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
                $eventAccount,
                new \DateTime($purchaseDate)
            );
    
            $eventVehicle = $this->handleEventVehicle(
                new \DateTime($eventDate),
                $vehicle,
                $eventAccount
            );
    
            $lastEventVehicle = $this->handleEventVehicle(
                new \DateTime($lastEventDate),
                $vehicle,
                $lastEventAccount
            );
    
            $civility = $this->handleCivility($civilityLabel);
            $city = $this->handleCity($cityName, $postalCode);
            $saleType = $this->handleSaleType($vnVoType);
            
            $seller = $vnSeller ?? $voSeller;
            $seller = $this->handleSeller($seller);
    
            $prospectType = $this->handleProspectType($prospectType);
    
            $recordFile = $this->handleRecordFile(
                $recordFileNo,
                $civility,
                $lastName,
                $firstName,
                $trackNumberAndName,
                $additionalAddress1,
                $homePhone,
                $cellPhone,
                $jobPhone,
                $email,
                $vehicle,
                $currentVehicleOwner,
                $city,
                $seller,
                $saleType,
                $invoicingComment,
                $vnVoFolderNo,
                $saleIntermediary,
                $prospectType,
                $businessAccount
            );


        } // end for

        
    }

    private function saveInstance(object $instance): void{
        $this->entityManager->persist($instance);
        $this->entityManager->flush();
    }

    private function handleAccount(?string $accountName): ?Account
    {
        if(!$accountName)
            return null;

        $accountName = trim($accountName);
        $account = $this->accountRepository->findOneBy(["name" => $accountName]);
        
        if(!$account){
            $account = new Account();
            $account->setName($accountName);
            $this->saveInstance($account);
        }
        
        return $account;
    }

    private function handleVehicle(string $vin, string|null $registrationNo, \Datetime|null $dateOfCirculation, string|null $version, string|null $mileAge, Brand $brand, Model|null $model, Energy|null $energy, EventOrigin $eventOrigin, Account $eventAccount, \Datetime|null $dateofPurchase): Vehicle
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

    private function handleBrand(?string $name): ?Brand
    {
        if(!$name)
            return null;

        $name = trim($name);
        $brand = $this->brandRepository->findOneBy(["name" => $name]);

        if(!$brand){
            $brand = new Brand();
            $brand->setName($name);
    
            $this->saveInstance($brand);
        }
        
        return $brand;
    }

    private function handleModel(?string $name, Brand $brand): ?Model
    {
        if(!$name)
            return null;

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

    private function handleEnergy(?string $label): ?Energy
    {
        if(!$label)
            return null;

        $label = trim($label);
        $energy = $this->energyRepository->findOneBy(["label" => $label]);

        if(!$energy){
            $energy = new Energy();
            $energy->setLabel($label);

            $this->saveInstance($energy);
        }
        
        return $energy;
    }

    private function handleEventOrigin(?string $label): ?EventOrigin
    {   
        if(!$label)
            return null;

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

    public function handleCivility(?string $name): ?Civility
    {
        if(!$name)
            return null;

        $name = trim($name);
        $civility = $this->civilityRepository->findOneBy(["name" => $name]);

        if(!$civility){
            $civility = new Civility();
            $civility->setName($name);

            $this->saveInstance($civility);
        }
        return $civility;
    }

    public function handleCity(string $name, string $postCode): City
    {
        $name = trim($name);
        $postCode = trim($postCode);
        $city = $this->cityRepository->findOneBy(["name" => $name, "postCode" => $postCode]);

        if(!$city){
            $city = new City();
            $city->setName($name);
            $city->setPostCode($postCode);

            $this->saveInstance($city);
        }
        return $city;
    }

    public function handleSaleType(string $label): SaleType
    {
        $label = trim($label);
        $saleType = $this->saleTypeRepository->findOneBy(["label" => $label]);

        if(!$saleType){
            $saleType = new SaleType();
            $saleType->setLabel($label);

            $this->saveInstance($saleType);
        }

        return $saleType;
    }

    public function handleSeller(?string $name): ?Seller
    {
        if(!$name)
            return null;
        
        $name = trim($name);
        $seller = $this->sellerRepository->findOneBy(["name" => $name]);

        if(!$seller){
            $seller = new Seller();
            $seller->setName($name);

            $this->saveInstance($seller);
        }
        return $seller;
    }

    public function handleProspectType($label): ProspectType
    {
        $label = trim($label);
        $prospectType = $this->prospectTypeRepository->findOneBy(["label" => $label]);

        if(!$prospectType){
            $prospectType = new ProspectType();
            $prospectType->setLabel($label);

            $this->saveInstance($prospectType);
        }
        return $prospectType;
    }
    private function handleRecordFile(string $recordNo, Civility|null $civility, string $lastName, string|null $firstName, string|null $trackNumberName, string|null $additionalAddress1, string|null $homePhone, string|null $cellPhone, string|null $jobPhone, string|null $email, Vehicle $vehicle, string|null $currentVehicleOwner, City $city, Seller|null $seller, SaleType $saleType, string|null $invoicingComment, string|null $saleFolderNo, string|null $saleIntermediary, ProspectType $prospectType, Account $businessAccount): RecordFile
    {
        $recordNo = trim($recordNo);
        $recordFile = $this->recordFileRepository->findOneBy(["recordNo" => $recordNo]);

        if(!$recordFile){
            $recordFile = new RecordFile();
            $recordFile->setRecordNo($recordNo);
            $recordFile->setCivility($civility);
            $recordFile->setLastName($lastName);
            $recordFile->setFirstName($firstName);
            $recordFile->setTrackNumberName($trackNumberName);
            $recordFile->setAdditionalAddress1($additionalAddress1);
            $recordFile->setHomePhone($homePhone);
            $recordFile->setCellPhone($cellPhone);
            $recordFile->setJobPhone($jobPhone);
            $recordFile->setEmail($email);
            $recordFile->setVehicle($vehicle);
            $recordFile->setCurrentVehicleOwner($currentVehicleOwner);
            $recordFile->setCity($city);
            $recordFile->setSeller($seller);
            $recordFile->setSaleType($saleType);
            $recordFile->setInvoicingComment($invoicingComment);
            $recordFile->setSaleFolderNo($saleFolderNo);
            $recordFile->setSaleIntermediary($saleIntermediary);
            $recordFile->setProspectType($prospectType);

            $this->saveInstance($recordFile);

        }
        return $recordFile;
    }

    public function handleEventVehicle(\DateTime $dateEvent, Vehicle $vehicle, Account $account): EventVehicle
    {
        $event = $this->eventVehicleRepository->findOneBy(["dateEvent" => $dateEvent, "vehicle" => $vehicle, "account" => $account]);

        if(!$event){
            $event = new EventVehicle();
            $event->setDateEvent($dateEvent);
            $event->setVehicle($vehicle);
            $event->setAccount($account);

            $this->saveInstance($event);
        }
        return $event;
    }

}   