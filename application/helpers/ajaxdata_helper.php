<?php

function getData(
    $config = array(
        'function'      => 'getData',
        'url'           => 'controller/function/',
        'param'         => '',
        'field'         => array('field1', 'field2'),
        'variable'      => array('idx' => 'idx'),
        'start'         => 1,
        'limit'         => 10,
        'row_count'     => 10,
        'keyword_id'    => 'q',
        'limit_id'      => 'limit',
        'data_id'       => 'data',
        'page_id'       => 'pagination',
        'jquery'        => 'assets/bower_components/jquery/dist/jquery.js',
        'number'        => true,
        'action'        => true,
        'load'          => true,
        'action_button' => ''
    )
) {
    /**
     * config=array(
     *      'url'           => 'controller/function/',
     *      'header'        => array('header1','header2')
     *      'param'         => array('field1'=>$param1,'field2'=>$param2), //Parameter tambahan
     *      'field'         => array('field1','field2','ect'),  // Field Yang Akan Ditampilkan (Samakan dengan nama Field Yang Ada Di Database)
     *      'start'         => 0,                               // Start Record
     *      'limit'         => 10,                              // Limit data
     *      'row_count'     => $row_count,
     *      'keyword_id'    => 'q',
     *      'limit_id'      => 'limit',
     *      'param_id'      => 'param',
     *      'data_id'       => 'data'
     * );
     */
    //Buat Header
    $colspan = count($config["field"]);
    if ($config["number"] == true) $colspan++;
    if ($config["action"] == true) $colspan++;
    $html = '';
    $html .= 'function ' . $config["function"] . '(start){';
    $html .= "$('#start').val(start);";
    $html .= "var search = $('#" . $config["keyword_id"] . "').val();";
    $html .= "var limit = $('#" . $config["limit_id"] . "').val();";
    $html .= "var param = $('#" . $config["param_id"] . "').val();";
    $html .= "var url = '" . base_url() . $config["url"] . "?keyword=' + search + \"&start=\" + start + \"&limit=\" + limit + \"&param=\" + param;";
    $html .= "$.ajax({
        url     : url,
        type    : \"GET\",
        dataType: \"json\",
        data    : {get_param : 'value'},
        beforeSend: function () {
            var tabel = \"<tr id='loading'><td colspan='" . $colspan . "'><b>Loading...</b></td></tr>\";
            $('#" . $config["data_id"] . "').html(tabel);
            $('#" . $config["page_id"] . "').html('');
        },";
    $html .= "success : function(data){
        //menghitung jumlah data
        
        if(data[\"status\"]==true){
            $('#" . $config["data_id"] . "').html('');
            var res    = data[\"data\"];
            var jmlData=res.length;
            var limit   = data[\"limit\"];
            var tabel   = \"\";
            //Create Tabel
            var no = (parseInt(start)*parseInt(limit))-parseInt(limit);
            var dari = no+1;
            var sampai = no+parseInt(limit);
            var desc = \"<button class='btn btn-default btn-sm' type='button'>Showing \"+ dari + \" To \" + sampai + \" of \" +data[\"row_count\"]+\"</button>\";
            for(var i=0; i<jmlData;i++){
                no++;
                tabel=\"<tr>\";";
    if ($config["number"] == true) $html .= "tabel+=\"<td>\"+no+\"</td>\";";
    $field = $config["field"];
    //$field = array('as', 'as');
    $jmldata = count($field);
    for ($i = 0; $i < $jmldata; $i++) {
        $exp = explode('{{', $field[$i]);
        $f = '';
        if (count($exp) > 1) {
            $f = $field[$i];
            $no = 0;
            foreach ($config["variable"] as $var => $val) {
                $no++;
                if ($no == 1) $f = str_replace('{{' . $var . '}}', '+res[i]["' . $val . '"]+"', $f);
                else $f = $f = str_replace('{{' . $var . '}}', '"+res[i]["' . $val . '"]+"', $f);
            }
        } else {
            $f = "\"+res[i]['" . $field[$i] . "']+\"";
        }
        $html .= "
        tabel+=\"<td>" . $f . "</td>\";";
    }
    if ($config['action'] == true) {
        $exp = explode('{{', $config["action_button"]);
        if (count($exp) > 1) {
            $no = 0;
            $ab = $config["action_button"];
            foreach ($config["variable"] as $var => $val) {
                $no++;
                $ab = $ab = str_replace('{{' . $var . '}}', '"+res[i]["' . $val . '"]+"', $ab);
            }
            //echo $ab;
        }
        $html .= "
        tabel+=\"<td>" . $ab . "</td>\";";
    }
    $html .= "tabel+=\"</tr>\";
                $('#" . $config["data_id"] . "').append(tabel);
            }
            //Create Pagination
            if(data[\"row_count\"]<=limit){
                $('#" . $config["page_id"] . "').html(\"\");
            }else{
                console.log(\"buat Pagination\");
                var pagination=\"\";
                var btnIdx=\"\";
                jmlPage = Math.ceil(data[\"row_count\"]/limit);
                offset  = data[\"start\"] % limit;
                /*curIdx  = Math.ceil((data[\"start\"]/data[\"limit\"])+1);
                prev    = (curIdx-2) * data[\"limit\"];
                next    = (curIdx) * data[\"limit\"];*/
    
                
                //var curSt=(curIdx*data[\"limit\"])-jmlData;
                //var mulai = start;
                var curIdx = start;
                var btn=\"btn-default\";
                //var lastSt=jmlPage;
                var btnFirst=\"<button class='btn btn-default btn-sm' onclick='" . $config['function'] . "(1)'><span class='fa fa-angle-double-left'></span></button>\";
                if (curIdx > 1) {
                    var prevSt=curIdx-1;
                    btnFirst+=\"<button class='btn btn-default btn-sm' onclick='" . $config['function'] . "(\"+prevSt+\")'><span class='fa fa-angle-left'></span></button>\";
                }
    
                var btnLast=\"\";
                if(curIdx<jmlPage){
                    var nextSt=curIdx+1;
                    btnLast+=\"<button class='btn btn-default btn-sm' onclick='" . $config['function'] . "(\"+nextSt+\")'><span class='fa fa-angle-right'></span></button>\";
                }
                console.log(curIdx);
                btnLast+=\"<button class='btn btn-default btn-sm' onclick='" . $config['function'] . "(\"+jmlPage+\")'><span class='fa fa-angle-double-right'></span></button>\";
                
                if(jmlPage>=5){
                    console.clear();
                    console.log('Jumlah Halaman > 5');
                    if(curIdx>=3){
                        console.log('Cur Idx >= 3');
                        var idx_start=curIdx - 2;
                        var idx_end=curIdx + 2;
                        if(idx_end>=jmlPage) idx_end=jmlPage;
                    }else{
                        var idx_start=1;
                        var idx_end=5;
                    }
                    for (var j = idx_start; j<=idx_end; j++) {
                        if(curIdx==j)  btn=\"btn-success\"; else btn= \"btn-default\";
                        btnIdx+=\"<button class='btn \" +btn +\" btn-sm' onclick='" . $config['function'] . "(\"+ j +\")'>\" + j +\"</button>\";
                    }
                }else{
    
                    for (var j = 1; j<=jmlPage; j++) {
                        if(curIdx==j)  btn=\"btn-success\"; else btn= \"btn-default\";
                        btnIdx+=\"<button class='btn \" +btn +\" btn-sm' onclick='" . $config['function'] . "(\"+ j +\")'>\" + j +\"</button>\";
                    }
                }
                pagination+=\"<div class='btn-group'>\"+desc+btnFirst + btnIdx + btnLast+\"</div>\";
                $('#" . $config["page_id"] . "').html(pagination);
            }
        }
    },
    complete : function(){
        //$('#loading').hide();
    }";
    $html .= "});";
    $html .= '}';
    if ($config["load"] == 1) $html .= $config['function'] . "(1)";
    return $html;
    //Buat Body

}

function dateIndo($date){
    $tgl=explode('-',$date);
    $new=$tgl[2]."/".$tgl[1]."/".$tgl[0];
    return $new;
}
function dateEng($date){
    $tgl=explode('/',$date);
    $new=$tgl[2]."-".$tgl[1]."-".$tgl[0];
    return $new;
}