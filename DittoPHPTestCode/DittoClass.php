<?php

class DittoClass {
    
    protected $_year = "";
    protected $_fileName = "";
    protected $_values = [];

    public function __construct($fileName = 'pay-day.csv', $year = false)
    {
        if($year){
            $this->_year = $year;
        }
        else{
            $this->_year = date("Y");
        }

        $this->_fileName = $fileName;
         $this->_values = [
             ['month' => 'January'],
             ['month' => 'February'],
             ['month' => 'March'],
             ['month' => 'April'],
             ['month' => 'May'],
             ['month' => 'June'],
             ['month' => 'July'],
             ['month' => 'August'],
             ['month' => 'September'],
             ['month' => 'October'],
             ['month' => 'November'],
             ['month' => 'December']
         ];
         
     }

    public function findBonusDate(){
    $bonusDate = 15;
    for ($i = 0; $i < count($this->_values); $i++) {
        $day = date("l", mktime(0, 0, 0, $i + 1, $bonusDate, $this->_year));
        if ($day === 'Saturday') {
            $this->_values[$i]['bonus'] = $bonusDate + 4;
        } else if ($day === 'Sunday') {
            $this->_values[$i]['bonus'] = $bonusDate + 3;
        } else {
            $this->_values[$i]['bonus'] = $bonusDate;
        }
    }
}

    public function findSalaryDate()
    {
        for($i = 0; $i < count($this->_values); $i++)
        {
            $day = new DateTime($this->_year . '-' . ($i + 1) . '-1');
            $day_month = date("l", mktime(0, 0, 0, $i + 1, $day->format( 't' ), $this->_year));
            if($day_month === 'Saturday')
            {
                $this->_values[$i] += ['salary' => intval($day->format( 't' )) - 1];
            }
            else if($day_month === 'Sunday')
            {
                $this->_values[$i] += ['salary' => intval($day->format( 't' )) - 2];
            }
            else{
                $this->_values[$i] += ['salary' => intval($day->format( 't' ))];
            }
        }
    }

    public function csvOutput()
    {
        //open the file
        $f = fopen($this->_fileName, 'w');
        if ($f === false) {
            throw new Exception('Error opening the file ' . $this->_fileName);
        }
        else{
            fputcsv($f, ['Month', 'Bonus', 'Salary']);
            foreach ($this->_values as $row) {
                fputcsv($f, $row);
            }
        }
        // close the file
        fclose($f);
    }
}
?>