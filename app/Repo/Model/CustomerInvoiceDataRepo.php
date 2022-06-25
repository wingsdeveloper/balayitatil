<?php

namespace App\Repo\Model;

use App\CustomerInvoiceData;
use App\Helpers\Helper;

class CustomerInvoiceDataRepo {
    public function createWithRequest($prereservation, $faturaData, $customer, $tc = '1',  $fatura_kesilecek = '0', $customer_type = 'possible')
    {

        /*TODO $rezervasyonu kullanarak ve form request datayi kullanarak yeni bir CustomerInvoceData olusturlim*/

        $prereservation_id = $prereservation->id;

        $identification = (isset($faturaData['identification']) && empty($faturaData['identification'])) ? '11111111111' : $faturaData['identification'];

        if(($fatura_kesilecek == null) || ($fatura_kesilecek == '0')) {
            $identification = $customer->idnumber ?? '11111111111';

            $name = Helper::splitName($customer->name);
            $customer_firstname = $name['firstname'];
            $customer_middlename = $name['middlename'];
            $customer_lastname = $name['lastname'];
            $customer_name = $customer_firstname . ' ' . $customer_middlename;

            if($customer_type == 'possible') {
                CustomerInvoiceData::create([
                    'pre_reservation_id' =>  $prereservation_id,
                    'pre_customer_id' => $customer->id,
                    'name' => $customer_name,
                    'surname' => $customer_lastname,
                    'identification' => $identification,
                    'email' => $customer->email,
                    'billing_address' => $customer->address,
                    'ulke_id' => 223,
                    'il_id' => null,
                    'ilce_id' => null,
                    'billing_type' => 'GERCEKKISI'
                ]);
            } else {

                CustomerInvoiceData::create([
                    'pre_reservation_id' =>  $prereservation_id,
                    'customer_id' => $customer->id,
                    'name' => $customer_name,
                    'surname' => $customer_lastname,
                    'identification' => $identification,
                    'email' => $customer->email,
                    'billing_address' => $customer->address,
                    'ulke_id' => 223,
                    'il_id' => null,
                    'ilce_id' => null,
                    'billing_type' => 'GERCEKKISI'
                ]);
            }

        } else {

            if($faturaData['billing_type'] == '0') {
                /*TODO bireysel kisi kaydi yapilacaktir.*/

                if($customer_type == 'possible') {
                    CustomerInvoiceData::create([
                        'pre_reservation_id' =>  $prereservation_id,
                        'pre_customer_id' => $customer->id,
                        'name' => $faturaData['name'],
                        'surname' => $faturaData['surname'],
                        'identification' => $identification,
                        'email' => $faturaData['email'],
                        'billing_address' => $faturaData['billing_address'],
                        'ulke_id' => $faturaData['ulke_id'],
                        'il_id' => $faturaData['il_id'],
                        'ilce_id' => $faturaData['ilce_id'],
                        'billing_type' => 'GERCEKKISI'
                    ]);
                } else {
                    CustomerInvoiceData::create([
                        'pre_reservation_id' =>  $prereservation_id,
                        'customer_id' => $customer->id,
                        'name' => $faturaData['name'],
                        'surname' => $faturaData['surname'],
                        'identification' => $identification,
                        'email' => $faturaData['email'],
                        'billing_address' => $faturaData['billing_address'],
                        'ulke_id' => $faturaData['ulke_id'],
                        'il_id' => $faturaData['il_id'],
                        'ilce_id' => $faturaData['ilce_id'],
                        'billing_type' => 'GERCEKKISI'
                    ]);
                }
            } else {
                /*TODO firma kaydi yapilacaktir.*/
                CustomerInvoiceData::create([
                    'pre_reservation_id' =>  $prereservation_id,
                    'customer_id' => $customer->id,
                    'name' => $faturaData['name'],
                    'surname' => $faturaData['surname'],
                    'identification' => $identification,
                    'email' => $faturaData['email'],
                    'billing_address' => $faturaData['billing_address'],
                    'ulke_id' => $faturaData['ulke_id'],
                    'il_id' => $faturaData['il_id'],
                    'ilce_id' => $faturaData['ilce_id'],
                    'billing_type' => 'TUZELKISI'
                ]);
            }
        }




    }
}
