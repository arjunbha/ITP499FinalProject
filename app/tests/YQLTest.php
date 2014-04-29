<?php
/**
 * Created by PhpStorm.
 * User: arjunbhargava
 * Date: 4/28/14
 * Time: 10:36 PM
 */

class YQLTest extends TestCase {


    public function testGetPrice() {
        $YQL = new ITP\API\YQL();
        $testDate = "2014-04-16";
        $testTickerValid = "TSLA";
        $testTickerInValid = "TSLAINVALID";

        $resultsValid = $YQL->getPrice($testDate,$testTickerValid);
        $this->assertEquals('199.11', $resultsValid);

        $resultsInValid = $YQL->getPrice($testDate,$testTickerInValid);
        $this->assertEquals("N/A", $resultsInValid);
    }

    public function testValidateStock() {
        $YQL = new ITP\API\YQL();
        $testTickerValid = "TSLA";
        $testTickerInValid = "TSLAINVALID";

        $boolValid = $YQL->validateStock($testTickerValid);
        $this->assertEquals(true,$boolValid);

        $boolInValid = $YQL->validateStock($testTickerInValid);
        $this->assertEquals(false,$boolInValid);
    }
}