<?php

/**
 * Berechnet alle ben&ouml;tigten, statistischen Werte.
 * 
 * @author Tobias Beckmerhagen
 *
 */
class CoffeeStatistics {
	
	private $coffeeConsumption = null;
	private $coffeeCosts = null;
	
	/**
	 * Klassenkonstruktor
	 * 
	 * @param Array $consumption Verbrauchsinformationen
	 * @param Array $costs Kosteninformationen
	 */
	public function __construct($consumption, $costs) {
		$this->coffeeConsumption['lastCounterNum'] = $consumption[0];
		$this->coffeeConsumption['penultimateCounterNum'] = $consumption[1];
		$this->coffeeConsumption['lastDate'] = $consumption[2];
		$this->coffeeConsumption['penultimateDate'] = $consumption[3];
		$this->coffeeConsumption['amountAtPenultimateEntry'] = $consumption[4];
		

	}
	
	/**
	 * Berechnet den Kaffeeverbraucht f&uuml;r: <br />
	 * - Tassen pro Tag<br />
	 * - Tassen pro Kilogramm<br />
	 * - Tage pro Kilogramm
	 *  
	 */
	private function calculateCoffeeConsumption() {
		$this->coffeeConsumption['cupsPerDay'] = ($this->coffeeConsumption['lastCounterNum'] - $this->coffeeConsumption['penultimateCounterNum']) / ($this->coffeeConsumption['lastDate'] - $this->coffeeConsumption['penultimateDate']);
		$this->coffeeConsumption['cupsPerKilogramm'] = ($this->coffeeConsumption['lastCounterNum'] - $this->coffeeConsumption['penultimateCounterNum']) / $this->coffeeConsumption['amountAtPenultimateEntry'] * 1000;
		$this->coffeeConsumption['daysPerKilogramm'] = ($this->coffeeConsumption['lastDate'] - $this->coffeeConsumption['penultimateDate']) / $this->coffeeConsumption['amountAtPenultimateEntry'] * 1000;
	}
	
	private function calculateCoffeeCosts() {
		$this->coffeeCosts['costsPerMonth'] = ($costsLastXcoffeePurchases / $this->coffeeConsumption['daysPerKilogramm'] * 30); // + ($costsLastXmilkPurchases / $this->milkConsumption['daysPerLiter'] * 30)
		$this->coffeeCosts['costsPerMonthPerPerson'] = $this->coffeeCosts['costsPerMonth'] / ($countEmployee + $countHiWi / 2);
		$this->coffeeCosts['calculatetInputEmployee'] = null;
		$this->coffeeCosts['calculatetInputHiWi'] = null;
		$this->coffeeCosts['calculatetInputEmployeeReserve'] = null;
		$this->coffeeCosts['calculatetInputHiWiReserve'] = null;
		$this->coffeeCosts['statedInputEmployee'] = null;
		$this->coffeeCosts['statedInputHiWi'] = null;

/*
monatliche Kosten
[(kosten der letzten 'n' Kaffee Einkäufe) / (durchschnittliche verbrauchszeit (in Tagen) für 1kg kaffee) * 30] + [(kosten der letzten 'n' Milch Einkäufe) / (durchschnittliche verbrauchszeit (in Tagen) für 1L Milch) * 30]

monatliche Kosten pro Person
monatliche Kosten / (Teilnehmer Mitarbeiter + Teilnehmer HiWi / 2)

Beitrag rechnerisch (Mitarbeiter)
((Anzahl Teilnehmer Mitarbeiter * Mittelwert der letzten 5 monatlichen Kosten pro Person) + (Anzahl Teilnehmer HiWi * Mittelwert der letzten 5 monatlichen Kosten pro Person) / 2) / (Anzahl Teilnehmer Mitarbeiter + 0,5 * Anzahl Teilnehmer HiWi)

Beitrag rechnerisch (HiWi)
Beitrag rechnerisch (Mitarbeiter) / 2

Beitrag incl. Rücklage (Mitarbeiter)
Beitrag rechnerisch (Mitarbeiter) + monatliche Rücklage / (Anzahl Teilnehmer Mitarbeiter + Anzahl Teilnehmer HiWi * 0,5)

Beitrag incl. Rücklage (HiWi)
Beitrag rechnerisch (HiWi) + monatliche Rücklage / (Anzahl Teilnehmer Mitarbeiter + Anzahl Teilnehmer HiWi * 0,5) / 2

festgesetzter Beitrag (Mitarbeiter)
Beitrag incl. Rücklage Mitarbeiter aufgerundet auf die nächst größeren 50 EUR-Cent

festgesetzter Beitrag (HiWi)
festgesetzter Beitrag (Mitarbeiter) / 2

*/

	}
	
	public function getCoffeeConsumption() {
		return $this->coffeeConsumption;
	}
	
	public function getCoffeeCosts() {
		return $this->coffeeCosts;
	}
	
}

?>