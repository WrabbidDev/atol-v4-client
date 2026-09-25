<?php

declare(strict_types=1);

namespace WrDev\AtolV4Client\DTO\Register;

use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

final class Item
{
    #[Serializer\Type("string")]
    private string $name;

    #[Serializer\Type("float")]
    private float $price;

    #[Serializer\Type("float")]
    private float $quantity;

    #[Serializer\Type("float")]
    private float $sum;

    #[Serializer\Type("string")]
    #[Serializer\SerializedName("measurement_unit")]
    #[Assert\Length(max: 16)]
    private ?string $measurementUnit = null;

    #[Serializer\Type("Enum<'WrDev\AtolV4Client\DTO\Register\PaymentMethod'>")]
    #[Serializer\SerializedName("payment_method")]
    private PaymentMethod $paymentMethod;

    #[Serializer\Type("Enum<'WrDev\AtolV4Client\DTO\Register\PaymentObject'>")]
    #[Serializer\SerializedName("payment_object")]
    private ?PaymentObject $paymentObject = null;

    #[Serializer\Type("WrDev\AtolV4Client\DTO\Register\Vat")]
    private Vat $vat;

    #[Serializer\Type("WrDev\AtolV4Client\DTO\Register\AgentInfo")]
    #[Serializer\SerializedName("agent_info")]
    private ?AgentInfo $agentInfo = null;

    #[Serializer\Type("WrDev\AtolV4Client\DTO\Register\SupplierInfo")]
    #[Serializer\SerializedName("supplier_info")]
    private ?SupplierInfo $supplierInfo = null;

    #[Serializer\Type("string")]
    #[Serializer\SerializedName("user_data")]
    #[Assert\Length(max: 64)]
    private ?string $userData = null;

    #[Serializer\Type("string")]
    #[Serializer\SerializedName("nomenclature_code")]
    #[Assert\Length(max: 150)]
    private ?string $nomenclatureCode = null;

    #[Serializer\Type("float")]
    #[Assert\PositiveOrZero]
    private ?float $excise = null;

    #[Serializer\Type("string")]
    #[Serializer\SerializedName("country_code")]
    #[Assert\Length(min: 1, max: 3)]
    #[Assert\Regex(pattern: "/^[0-9]*$/")]
    private ?string $countryCode = null;

    #[Serializer\Type("string")]
    #[Serializer\SerializedName("declaration_number")]
    #[Assert\Length(min: 1, max: 32)]
    private ?string $declarationNumber = null;

    public function __construct(
        string $name,
        float $price,
        float $quantity,
        float $sum,
        PaymentMethod $paymentMethod,
        Vat $vat,
    ) {
        $this->name = $name;
        $this->price = $price;
        $this->quantity = $quantity;
        $this->sum = $sum;
        $this->paymentMethod = $paymentMethod;
        $this->vat = $vat;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getQuantity(): float
    {
        return $this->quantity;
    }

    public function setQuantity(float $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getSum(): float
    {
        return $this->sum;
    }

    public function setSum(float $sum): self
    {
        $this->sum = $sum;

        return $this;
    }

    public function getMeasurementUnit(): ?string
    {
        return $this->measurementUnit;
    }

    public function setMeasurementUnit(?string $measurementUnit): self
    {
        $this->measurementUnit = $measurementUnit;

        return $this;
    }

    public function getPaymentMethod(): PaymentMethod
    {
        return $this->paymentMethod;
    }

    public function setPaymentMethod(PaymentMethod $paymentMethod): self
    {
        $this->paymentMethod = $paymentMethod;

        return $this;
    }

    public function getPaymentObject(): ?PaymentObject
    {
        return $this->paymentObject;
    }

    public function setPaymentObject(?PaymentObject $paymentObject): self
    {
        $this->paymentObject = $paymentObject;

        return $this;
    }

    public function getVat(): Vat
    {
        return $this->vat;
    }

    public function setVat(Vat $vat): self
    {
        $this->vat = $vat;

        return $this;
    }

    public function getAgentInfo(): ?AgentInfo
    {
        return $this->agentInfo;
    }

    public function setAgentInfo(?AgentInfo $agentInfo): self
    {
        $this->agentInfo = $agentInfo;

        return $this;
    }

    public function getSupplierInfo(): ?SupplierInfo
    {
        return $this->supplierInfo;
    }

    public function setSupplierInfo(?SupplierInfo $supplierInfo): self
    {
        $this->supplierInfo = $supplierInfo;

        return $this;
    }

    public function getUserData(): ?string
    {
        return $this->userData;
    }

    public function setUserData(?string $userData): self
    {
        $this->userData = $userData;

        return $this;
    }

    public function getNomenclatureCode(): ?string
    {
        return $this->nomenclatureCode;
    }

    public function setNomenclatureCode(?string $nomenclatureCode): self
    {
        $this->nomenclatureCode = $nomenclatureCode;

        return $this;
    }

    public function getExcise(): ?float
    {
        return $this->excise;
    }

    public function setExcise(?float $excise): self
    {
        $this->excise = $excise;

        return $this;
    }

    public function getCountryCode(): ?string
    {
        return $this->countryCode;
    }

    public function setCountryCode(?string $countryCode): self
    {
        $this->countryCode = $countryCode;

        return $this;
    }

    public function getDeclarationNumber(): ?string
    {
        return $this->declarationNumber;
    }

    public function setDeclarationNumber(?string $declarationNumber): self
    {
        $this->declarationNumber = $declarationNumber;

        return $this;
    }

}
