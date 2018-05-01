<?php
class listPresenter{
    public $arrColumns;
    public $arrValues;
    public $accHtml;

    public function __construct($arrColumns, $arrValues){
        $this->arrColumns = $arrColumns;
        $this->arrValues = $arrValues;
        $this->accHtml = "";
    }



    //foreach ($this->arrValues as $rows
    // foreach ($this->arrColumns as $key => $value)
    // echo $rows[$key]


    //foreach($user->getAll())
    // $values["options"] = htmltool::linkicon("?mode=edit&id=values[id], "edit)

    // $users = $values;
    public function listTable(){
        $this->accHtml .= "\n<table class='table table-striped'>\t";
        $this->accHtml .= "\n<thead>\n\t";
        $this->accHtml .= "<tr>\n";

        foreach ($this->arrColumns as $value) {
            $this->accHtml .= "\t\t<th scope='col'>$value</th>\n";
        }
        $this->accHtml .= "\t</tr>\n";
        $this->accHtml .= "</thead>\n";
        $this->accHtml .= "<tbody>\n";
        foreach ($this->arrValues as $rows){
            $this->accHtml .= "<tr>\n";
            foreach ($this->arrColumns as $key => $value) {
                $this->accHtml .= "\t<td>$rows[$key]</td>\n";
            }
            $this->accHtml .= "</tr>\n";
        }
        $this->accHtml .= "</tbody>";
        $this->accHtml .= "</table>";

        return $this->accHtml;
    }

    public function listDetails(){
        $this->accHtml .= "<div class='row'>";
        $this->accHtml .= "<table class=\"table-striped table-details col-lg-6 mx-auto\">\n";
        foreach($this->arrValues as $key => $value) {
        if(isset($this->arrColumns[$key]) && $this->arrColumns[$key]) {
        $this->accHtml .= "<tr>\n";
        $this->accHtml .= "   <td><b>" . $this->arrColumns[$key] . ":</b></td>\n";
        $this->accHtml .= "   <td>" . $value .  "   </td>\n";
        $this->accHtml .= "</tr>\n";
            }
        }
        $this->accHtml .= "</table>\n";
        $this->accHtml .= "</div>";
        return $this->accHtml;
    }
}


?>