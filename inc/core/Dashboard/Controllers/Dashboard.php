<?php
namespace Core\Dashboard\Controllers;

class Dashboard extends \CodeIgniter\Controller
{
    public function __construct(){
        $this->config = parse_config( include realpath( __DIR__."/../Config.php" ) );
    }
    
    public function index( $page = false ) {
        $configs = get_blocks("block_dashboard", false, true);
        $items = [];

        __("Today");
        __("Jan");
        __("Feb");
        __("Mar");
        __("Apr");
        __("May");
        __("Jun");
        __("Jul");
        __("Aug");
        __("Sep");
        __("Oct");
        __("Nov");
        __("Dec");
        __("Sun");
        __("Mon");
        __("Tue");
        __("Wed");
        __("Thu");
        __("Fri");
        __("Sat");
        __("Last 7 days");
        __("Last 28 days");
        __("This month");
        __("Last month");
        __("Apply");
        __("Cancel");
        __("W");
        __("Custom Range");
        __("January");
        __("February");
        __("March");
        __("April");
        __("May");
        __("June");
        __("July");
        __("August");
        __("September");
        __("October");
        __("November");
        __("December");
        __("Sunday");
        __("Monday");
        __("Tuesday");
        __("Wednesday");
        __("Thursday");
        __("Friday");
        __("Saturday");
        __("Su");
        __("Mo");
        __("Tu");
        __("We");
        __("Th");
        __("Fr");
        __("Sa");
        __("Next");
        __("Prev");
        __("Done");
        __("Choose Time");
        __("Wk");
        __("Time");
        __("Hour");
        __("Minute");
        __("Second");
        __("Millisecond");
        __("Microsecond");
        __("Time Zone");
        __("Now");

        if( ! empty($configs) ){
            $items = $configs;
            if( count($items) >= 2 ){
                usort($items, function($a, $b) {
                    if( isset($a['data']['position']) &&  isset($b['data']['position']) )
                        return $a['data']['position'] <=> $b['data']['position'];
                });
            }
        }

        $data = [
            "title" => $this->config['name'],
            "desc" => $this->config['desc'],
            "content" => view('Core\Dashboard\Views\content', ['result' => $items])
        ];

        return view('Core\Dashboard\Views\index', $data);
    }
}