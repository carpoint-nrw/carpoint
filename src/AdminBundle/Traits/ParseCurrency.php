<?php

namespace AdminBundle\Traits;

use AdminBundle\Entity\Currency;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Trait ParseCurrency
 *
 * @package AdminBundle\Traits
 */
trait ParseCurrency
{

    /**
     * @param EntityManagerInterface $em
     *
     * @return void
     */
    protected function getCurrencyRate(EntityManagerInterface $em)
    {
        $url = 'https://www.finanzen.net/devisen/euro-zloty-kurs';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        $data = curl_exec($ch);
        $info = curl_getinfo($ch);
        curl_close ($ch);

        if ($info['http_code'] !== 200) {
            if ($this->tryCount < 10) {
                $this->logger->error('parse', ['Incorrect http code' => $info['http_code']]);
                $this->tryCount++;

                return $this->getCurrency();
            }

            return 0;
        }

        $crawler = new Crawler($data);

        $currencyCrawler = $crawler
            ->filterXPath('.//div[contains(@class, "snapshot-headline")]//div[contains(@class, "quotebox")]//div[contains(@class, "col-xs-5")]');
        if (\count($currencyCrawler) <= 0) {
            $this->logger->error('parse', ['IncorrectHtml' => 'IncorrectHtml']);

            return 0;
        }

        $currencyData = $currencyCrawler->text();
        $currency = str_replace('PLN', '', $currencyData);
        $currency = str_replace(',', '.', $currency);
        $currency = trim($currency);
        $float = (float) $currency;
        $result = $float - 0.02;

        $currency = new Currency();
        $currency
            ->setRealCurrency($float)
            ->setOurCurrency($result);

        $em->persist($currency);
        $em->flush();
    }
}