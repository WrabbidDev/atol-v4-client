<?php

declare(strict_types=1);

namespace WrDev\AtolV4Client\DTO\Correction;

use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use WrDev\AtolV4Client\DTO\Register\Client;
use WrDev\AtolV4Client\DTO\Register\Company;
use WrDev\AtolV4Client\DTO\Register\Payment;
use WrDev\AtolV4Client\DTO\Register\Vat;

final class Correction
{
    #[Serializer\Type("WrDev\AtolV4Client\DTO\Register\Company")]
    #[Assert\Valid]
    private Company $company;

    #[Serializer\Type("WrDev\AtolV4Client\DTO\Register\Client")]
    #[Assert\Valid]
    private ?Client $client = null;

    #[Serializer\Type("WrDev\AtolV4Client\DTO\Correction\CorrectionInfo")]
    #[Serializer\SerializedName("correction_info")]
    #[Assert\Valid]
    private CorrectionInfo $correctionInfo;

    /** @var Payment[] */
    #[Serializer\Type("array<WrDev\AtolV4Client\DTO\Register\Payment>")]
    #[Assert\Count(max: 10)]
    #[Assert\Valid]
    private array $payments;

    /** @var Vat[] */
    #[Serializer\Type("array<WrDev\AtolV4Client\DTO\Register\Vat>")]
    #[Assert\Count(max: 6)]
    #[Assert\Valid]
    private array $vats;

    #[Serializer\Type("string")]
    #[Assert\Length(max: 64)]
    private ?string $cashier = null;

    #[Serializer\Type("string")]
    #[Serializer\SerializedName("device_number")]
    #[Assert\Length(max: 20)]
    private ?string $deviceNumber = null;

    #[Serializer\Type("bool")]
    private ?bool $internet = null;

    #[Assert\Callback]
    public function validateInternetClientCompatibility(ExecutionContextInterface $context): void
    {
        if ($this->internet === true && $this->client === null) {
            $context
                ->buildViolation('Client is required when internet is true')
                ->atPath('client')
                ->addViolation();
        }
    }

    /**
     * @param Payment[] $payments
     * @param Vat[] $vats
     */
    public function __construct(Company $company, CorrectionInfo $correctionInfo, array $payments, array $vats)
    {
        $this->company = $company;
        $this->correctionInfo = $correctionInfo;
        $this->payments = $payments;
        $this->vats = $vats;
    }

    public function getCorrectionInfo(): CorrectionInfo
    {
        return $this->correctionInfo;
    }

    public function setCorrectionInfo(CorrectionInfo $correctionInfo): self
    {
        $this->correctionInfo = $correctionInfo;

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

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

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
     * @return Correction
     */
    public function setPayments(array $payments): self
    {
        $this->payments = $payments;

        return $this;
    }

    /**
     * @return Vat[]
     */
    public function getVats(): array
    {
        return $this->vats;
    }

    /**
     * @param Vat[] $vats
     *
     * @return Correction
     */
    public function setVats(array $vats): self
    {
        $this->vats = $vats;

        return $this;
    }

    public function getCashier(): ?string
    {
        return $this->cashier;
    }

    /**
     * @param string $cashier
     *
     * @return Correction
     */
    public function setCashier(string $cashier): self
    {
        $this->cashier = $cashier;

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

    public function getInternet(): ?bool
    {
        return $this->internet;
    }

    public function setInternet(?bool $internet): self
    {
        $this->internet = $internet;

        return $this;
    }


}
