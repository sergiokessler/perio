<?php

// $Id$

require_once 'DB.php';
require_once 'HTML/QuickForm.php'; 
require_once 'share/data_utils.php';
 


function sak_record_form($params)
{
    global $config;

    $table_info2qf['varchar'] = 'text';
    $table_info2qf['int4']    = 'text';
    $table_info2qf['date']    = 'date';
    $table_info2qf['text']    = 'textarea';

    $date_options = array(
        'language'  => 'es',
        'format'    => 'dMY',
//        'minYear'   => 2005,
//        'maxYear'   => 2009
    );
    $date_defaults = array(
        'd' => date('d'),
        'M' => date('m'),
        'Y' => date('Y'),
    );
    $campos_cortos = array('size' => 3);
    $campos_medios = array('size' => 8);
    $campos_largos = array('size' => 64); 
    

    $table        = $params['table'];
    $primary_key  = $params['primary_key'];
    $op           = $params['op'];

    if ($op == 'update')
        $record_id = $params['record_id'];


    $db = DB::connect($config['db']);
    if (PEAR::isError($db)) {
        die($db->getMessage());
    }
    
    $params_f = params_encode($params);

    $form =& new HTML_QuickForm('form_record', 'post');
    $form->addElement('hidden', 'action', 'table');
    $form->addElement('hidden', 'params', $params_f);

    $table_info = $db->tableInfo($table);

    foreach ($table_info as $field_info)
    {
        $name  = $field_info['name'];
        $type = null;
        $options = null;

        if (isset($params['type'][$op][$name]))
            $type = $params['type'][$op][$name];

        if ($type == 'disable')
            continue;

        if ($name == $primary_key)
            continue;

        $type  = $type == '' ? $table_info2qf[$field_info['type']] : $type;
        $label = get_label($field_info['name']);
        $size  = $field_info['len'];

        if ($type == 'date')
        {
            $options = $date_options;
        }

        if ($type == 'textarea')
        {
            $options = array('rows' => 6, 'cols' => 70);
        }

        if ($type == 'text')
        {
            $options = array('size' => 40);
        }

        if (isset($params['options'][$name]))
        {
            $type = 'select';
            $options = $params['options'][$name];
        }

        if (isset($params['lookup'][$name]))
        {
            $type = 'select';

            $lookup_table = $params['lookup'][$name]['table'];
            $lookup_field_key = $params['lookup'][$name]['field_key'];
            $lookup_field_list = $params['lookup'][$name]['field_list'];
            $sql_options = "select $lookup_field_key, $lookup_field_list from $lookup_table order by $lookup_field_list";

            $options = array('' => '') + $db->getAssoc($sql_options);
        }

        if (isset($params['defaults'][$name]))
            $defaults[$name] = $params['defaults'][$name];

        $input_name = "new_row[$name]"; 
        $form->addElement($type, $input_name, $label, $options);

        if ($field_info['flags'] != '')
        {
            $not_null = strpos($field_info['flags'], 'not_null');
            if (!($not_null === false))
                $form->addRule($input_name, 'Campo obligatorio', 'required');
        }

        if ($field_info['type'] == 'int4')
        {
            $form->addRule($input_name, 'Campo numerico', 'numeric');
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
        $form->setDefaults($defaults);
    }

    $form->addElement('submit', 'btnSubmit', 'Guardar');

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


