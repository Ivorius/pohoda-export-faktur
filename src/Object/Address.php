<?php

namespace Pohoda\Object;

use Nette\Object;
use Pohoda\Validators;

/**
 * Author: Ivo Toman
 */
class Address
{

	private $company;
	private $name;
	private $division;
	private $city;
	private $street;
	private $number;
	private $zip;
	private $country;
	private $ico;
	private $dic;
	private $phone;
	private $email;


	public function __construct($value)
	{
		if (isset($value['name'])) {
			$this->name = $this->validateItem('name', $value['name'], 32);
		}
		if (isset($value['street'])) {
			$this->street = $this->validateItem('street', $value['street'], 64);
		}
		if (isset($value['zip'])) {
			$value['zip'] = $this->removeSpaces($value['zip']);
			$this->zip = $this->validateItem('zip', $value['zip'], 15, true);
		}
		if (isset($value['city'])) {
			$this->city = $this->validateItem('city', $value['city'], 45);
		}
		if (isset($value['phone'])) {
			$this->phone = $this->validateItem('phone', $value['phone'], 24);
		}
		if (isset($value['email'])) {
			$this->email = $this->validateItem('email', $value['email'], 98);
		}
		if (isset($value['company'])) {
			$this->company = $this->validateItem('company', $value['company'], 96);
		}
		if (isset($value['division'])) {
			$this->division = $this->validateItem('division', $value['division'], 32);
		}
		if (isset($value['ico'])) {
			$value['ico'] = $this->removeSpaces($value['ico']);
			$this->ico = $this->validateItem('ico', $value['ico'], 15, true);
		}
		if (isset($value['dic'])) {
			$value['dic'] = $this->removeSpaces($value['dic']);
			$this->dic = $this->validateItem('dic', $value['dic'], 18);
		}

	}

	private function removeSpaces($value)
	{
		return preg_replace('/\s+/', '', $value);
	}


	private function validateItem($name, $value, $maxLength = false, $isNumeric = false)
	{
		try {
			if ($maxLength)
				Validators::assertMaxLength($value, $maxLength);
			if ($isNumeric)
				Validators::assertNumeric($value);

		} catch (\InvalidArgumentException $e) {
			throw new \InvalidArgumentException($name . " - " . $e->getMessage());
		}
		return $value;
	}


	/**
	 * @return mixed
	 */
	public function getCompany()
	{
		return $this->company;
	}

	/**
	 * @return mixed
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * @return mixed
	 */
	public function getStreet()
	{
		return $this->street;
	}

	/**
	 * @return mixed
	 */
	public function getNumber()
	{
		return $this->number;
	}

	/**
	 * @return mixed
	 */
	public function getCity()
	{
		return $this->city;
	}

	/**
	 * @return mixed
	 */
	public function getZip()
	{
		return $this->zip;
	}

	/**
	 * @return mixed
	 */
	public function getCountry()
	{
		return $this->country;
	}

	/**
	 * @return mixed
	 */
	public function getIco()
	{
		return $this->ico;
	}

	/**
	 * @return mixed
	 */
	public function getDic()
	{
		return $this->dic;
	}

	/**
	 * @return mixed
	 */
	public function getDivision()
	{
		return $this->division;
	}

	/**
	 * @return mixed
	 */
	public function getEmail()
	{
		return $this->email;
	}

	/**
	 * @return mixed
	 */
	public function getPhone()
	{
		return $this->phone;
	}

}

