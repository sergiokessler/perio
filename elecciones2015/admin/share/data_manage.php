<?php

// $Id: data_manage.php,v 1.1 2007/10/10 17:15:47 develop Exp $

require_once 'DB.php';
require_once 'HTML/QuickForm.php'; 
require_once 'share/data_utils.php';
 


function sak_record_form($params, $field_meta, $field_mapping = null)
{
    global $config;

    $table_info2qf['varchar'] = 'text';
    $table_info2qf['string']  = 'textarea';
    $table_info2qf['int4']    = 'text';
    $table_info2qf['int']     = 'text';
    $table_info2qf['date']    = 'date';
    $table_info2qf['timestamp'] = 'date';
    $table_info2qf['text']    = 'textarea';
    $table_info2qf['blob']    = 'textarea';

    $type_options['date'] = array (
        'language'  => 'es',
        'format'    => 'dMY',
//        'minYear'   => 2005,
//        'maxYear'   => 2009
    );

    $type_options['text'] = array('size' => 64);
    $type_options['textarea'] = array('rows' => 5, 'cols' => 64);

    $date_defaults = array(
        'd' => date('d'),
        'M' => date('m'),
        'Y' => date('Y'),
    );


    $table        = $params['table'];
    $primary_key  = $params['primary_key'];
    $op           = $params['op'];

    if ($op == 'update')
        $record_id = $params['record_id'];



    $db = DB::connect($config['db']);
    if (PEAR::isError($db)) {
	var_dump($db);
        die($db->getMessage());
    }
    
    $params_f = params_encode($params);

    $form =& new HTML_QuickForm('form_record', 'post');
    $form->setRequiredNote('<span style="color:#ff0000;">*</span> = campos requeridos.');
    $form->addElement('hidden', 'action', 'table');
    $form->addElement('hidden', 'params', $params_f);

    $table_info = $db->tableInfo($table);

    foreach ($table_info as $field_info)
    {
        $name  = $field_info['name'];
        $element_type = null;
        $element_options = null;

        if ( isset($field_meta['type'][$op][$name]) )
        {
            if ($field_meta['type'][$op][$name] == 'disable')
                continue;
            else
                $element_type = $field_meta['type'][$op][$name];
        }

//        if ($name == $primary_key)
//            continue;

        $element_type  = $element_type == '' ? $table_info2qf[$field_info['type']] : $element_type;
        if(isset($field_mapping[$field_info['name']]))
            $label = $field_mapping[$field_info['name']];
        else
            $label = get_label($field_info['name']);

        $size  = $field_info['len'];

        if (!empty($type_options[$element_type])) {
            $element_options = $type_options[$element_type];
        }

        if (isset($field_meta['select'][$name]))
        {
            $element_type = 'select';

            if (isset($field_meta['select'][$name]['data']))
                $element_options = $field_meta['select'][$name]['data'];
            else {
                $lookup_sql = $field_meta['select'][$name]['sql'];
                $element_options = $db->getAssoc($lookup_sql);
            }
        }

        $element_name = "new_row[$name]"; 

        if (isset($field_meta['defaults'][$name]))
            $defaults[$element_name] = $field_meta['defaults'][$name];

        $form->addElement($element_type, $element_name, $label, $element_options);

        if ($field_info['flags'] != '')
        {
            $not_null = strpos($field_info['flags'], 'not_null');
            if (!($not_null === false))
                $form->addRule($element_name, 'Campo obligatorio', 'required');
        }

        if ($field_info['type'] == 'int4')
        {
            $form->addRule($element_name, 'Campo numerico', 'numeric');
        }
    }

    if ($op == 'update')
    {
        $edit_sql = "select * from $table where $primary_key = ?";
        $edit_sql_data = array($record_id);
        $edit_row = $db->getRow($edit_sql, $edit_sql_data, DB_FETCHMODE_ASSOC);
    
        foreach($edit_row as $key => $value)
        {
            $defaults['new_row['.$key.']'] = stripslashes($value);
        }
    }

//    echo '<pre>';
//    var_dump($defaults);
//    echo '</pre>';

    if (isset($defaults)) {
        $form->setDefaults($defaults);
    }
    return($form);
}


function sak_record_form_process($values = null)
{
    global $config, $params;

//    $params = $values['params'];

    $table         = $params['table'];
    $op            = $params['op'];
    $primary_key   = $params['primary_key'];


    if (isset($values))
    {
        $new_row       = $values['new_row'];
    
        foreach($new_row as $key => $value)
        {
            if (is_array($value) and isset($value['d']))
                $new_row[$key] = get_date($value);

            if ($value == '')
                $new_row[$key] = null;
        }
    }

    $db = DB::connect($config['db']);
    if (PEAR::isError($db)) {
        die($db->getMessage());
    }

    if ($op == 'insert')
    { 
        $res = $db->autoExecute($table, $new_row, DB_AUTOQUERY_INSERT);
        $msg = "El registro a sido cargado satisfactoriamente.";
    }

    if ($op == 'update')
    {
        $record_id     = $params['record_id'];
        $res = $db->autoExecute($table, $new_row, DB_AUTOQUERY_UPDATE, "$primary_key = $record_id");
        $msg = "El registro a sido modificado satisfactoriamente.";
    }

    if ($op == 'delete')
    {
        $record_id     = $params['record_id'];
        $res = $db->query("delete from $table where $primary_key = ?", array($record_id));
        $msg = "El registro a sido eliminado satisfactoriamente.";
    }


    if (PEAR::isError($res)) {
        die( $res->getDebugInfo() );
    }

    return($msg);
}


