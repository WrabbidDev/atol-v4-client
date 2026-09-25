<?php

declare(strict_types=1);

namespace WrDev\AtolV4Client\DTO\Register;

use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

final class Receipt
{
    #[Serializer\Type("WrDev\AtolV4Client\DTO\Register\Client")]
    #[Assert\Valid]
    private Client $client;

    #[Serializer\Type("WrDev\AtolV4Client\DTO\Register\Company")]
    #[Assert\Valid]
    private Company $company;

    /** @var Item[] */
    #[Serializer\Type("array<WrDev\AtolV4Client\DTO\Register\Item>")]
    #[Assert\Count(min: 1)]
    #[Assert\Valid]
    private array $items;

    /** @var Payment[] */
    #[Serializer\Type("array<WrDev\AtolV4Client\DTO\Register\Payment>")]
    #[Assert\Count(min: 1, max: 10)]
    #[Assert\Valid]
    private array $payments;

    /** @var Vat[]|null */
    #[Serializer\Type("array<WrDev\AtolV4Client\DTO\Register\Vat>")]
    #[Assert\Count(max: 6)]
    #[Assert\Valid]
    private ?array $vats = null;

    #[Serializer\Type("WrDev\AtolV4Client\DTO\Register\AgentInfo")]
    #[Serializer\SerializedName("agent_info")]
    #[Assert\Valid]
    private ?AgentInfo $agentInfo = null;

    #[Serializer\Type("WrDev\AtolV4Client\DTO\Register\SupplierInfo")]
    #[Serializer\SerializedName("supplier_info")]
    #[Assert\Valid]
    private ?SupplierInfo $supplierInfo = null;

    #[Serializer\Type("string")]
    #[Serializer\SerializedName("additional_check_props")]
    #[Assert\Length(max: 16)]
    private ?string $additionalCheckProps = null;

    #[Serializer\Type("string")]
    #[Assert\Length(max: 64)]
    private ?string $cashier = null;

    #[Serializer\Type("WrDev\AtolV4Client\DTO\Register\AdditionalUserProps")]
    #[Serializer\SerializedName("additional_user_props")]
    #[Assert\Valid]
    private ?AdditionalUserProps $additionalUserProps = null;

    #[Serializer\Type("string")]
    #[Serializer\SerializedName("device_number")]
    #[Assert\Length(max: 20)]
    private ?string $deviceNumber = null;

    #[Serializer\Type("bool")]
    private ?bool $internet = null;

    /** @var CashlessPayment[]|null */
    #[Serializer\Type("array<WrDev\AtolV4Client\DTO\Register\CashlessPayment>")]
    #[Serializer\SerializedName("cashless_payments")]
    #[Assert\Valid]
    private ?array $cashlessPayments = null;

    #[Serializer\Type("float")]
    private float $total;

    /**
     * @param Client $client
     * @param Company $company
     * @param Item[] $items
     * @param Payment[] $payments
     * @param float $total
     */
    public function __construct(Client $client, Company $company, array $items, array $payments, float $total)
    {
        $this->client = $client;
        $this->company = $company;
        $this->items = $items;
        $this->payments = $payments;
        $this->total = $total;
    }

    public function getClient(): Client
    {
        return $this->client;
    }

    public function setClient(Client $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function getCompany(): Company
    {
        return $this->company;
    }

    public function setCompany(Company $company): self
    {
        $this->company = $company;

        return $this;
    }

    /**
     * @return Item[]
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @param Item[] $items
     *
     * @return Receipt
     */
    public function setItems(array $items): self
    {
        $this->items = $items;

        return $this;
    }

    /**
     * @return Payment[]
     */
    public function getPayments(): array
    {
        return $this->payments;
    }

    /**
     * @param Payment[] $payments
     *
     * @return Receipt
     */
    public function setPayments(array $payments): self
    {
        $this->payments = $payments;

        return $this;
    }

    /**
     * @return Vat[]|null
     */
    public function getVats(): ?array
    {
        return $this->vats;
    }

    /**
     * @param Vat[]|null $vats
     *
     * @return Receipt
     */
    public function setVats(?array $vats): self
    {
        $this->vats = $vats;

        return $this;
    }

    public function getInternet(): ?bool
    {
        return $this->internet;
    }

    public function setInternet(?bool $internet): self
    {
        $this->internet = $internet;

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

    public function getAdditionalCheckProps(): ?string
    {
        return $this->additionalCheckProps;
    }

    public function setAdditionalCheckProps(?string $additionalCheckProps): self
    {
        $this->additionalCheckProps = $additionalCheckProps;

        return $this;
    }

    public function getCashier(): ?string
    {
        return $this->cashier;
    }

    public function setCashier(?string $cashier): self
    {
        $this->cashier = $cashier;

        return $this;
    }

    public function getAdditionalUserProps(): ?AdditionalUserProps
    {
        return $this->additionalUserProps;
    }

    public function setAdditionalUserProps(?AdditionalUserProps $additionalUserProps): self
    {
        $this->additionalUserProps = $additionalUserProps;

        return $this;
    }

    public function getDeviceNumber(): ?string
    {
        return $this->deviceNumber;
    }

    public function setDeviceNumber(?string $deviceNumber): self
    {
        $this->deviceNumber = $deviceNumber;

        return $this;
    }

    /**
     * @return CashlessPayment[]|null
     */
    public function getCashlessPayments(): ?array
    {
        return $this->cashlessPayments;
    }

    /**
     * @param CashlessPayment[]|null $cashlessPayments
     */
    public function setCashlessPayments(?array $cashlessPayments): self
    {
        $this->cashlessPayments = $cashlessPayments;

        return $this;
    }

    public function getTotal(): float
    {
        return $this->total;
    }

    public function setTotal(float $total): self
    {
        $this->total = $total;

        return $this;
    }
}
