<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App;
use DB;

class GeneralController extends Controller
{
    public function addNew(Request $request)
    {
        $data = $request->all();

        if (@$data['name'] == NULL)
            $err[] = 'Требуется указать название.';

        if (@$data['category'] == NULL)
            $err[] = 'Требуется указать категорию.';

        if (@$data['summ'] == NULL)
            $err[] = 'Требуется указать сумму.';
        else if (!preg_match('#^[0-9]+$#', $data['summ']) )
            $err[] = 'Не правильно указана сумма.';

        if (@$data['date'] == NULL)
            $err[] = 'Требуется указать дату.';
        else {
            if ($this->validateDate($data['date']))
                $data['date'] = date('Y-m-d', strtotime($data['date'])).' 00:00:00';
            else
                $err[] = 'Не правильно указана дата.';
        }

        if (!@$err) App\General::insert( $data );

        return array(
            'success' => (bool)!@$err,
            'errors' => @$err
        );
    }

    public function delete(Request $request)
    {
        $data = $request->all();

        App\General::delete_rec( (int) $data['id'] );

        return 'OK';
    }

    public function edit(Request $request)
    {
        $data = $request->all();
               
        if (@$data['name'] == NULL)
            $err[] = 'Требуется указать название.';

        if (@$data['category'] == NULL)
            $err[] = 'Требуется указать категорию.';

        if (@$data['summ'] == NULL)
            $err[] = 'Требуется указать сумму.';
        else if (!preg_match('#^[0-9]+$#', $data['summ']) )
            $err[] = 'Не правильно указана сумма.';

        if (@$data['date'] == NULL)
            $err[] = 'Требуется указать дату.';
        else {
            if ($this->validateDate($data['date']))
                $data['date'] = date('Y-m-d', strtotime($data['date'])).' 00:00:00';
            else
                $err[] = 'Не правильно указана дата.';
        }

        if (!@$err) App\General::where( 'id', '=', (int) $data['id'] )->update([
            'date' => $data['date'],
            'name' => $data['name'],
            'category' => $data['category'],
            'summ' => $data['summ']
        ]);

        return array(
            'success' => (bool)!@$err,
            'errors' => @$err
        );
    }

    public function getItem(Request $request)
    {
        $data = $request->all();

        $ret = App\General::find( (int) $data['id'] );

        $ret['date'] = date('d.m.Y', strtotime($ret['date']));

        return $ret;
    }

    public function getList (Request $request) {

    	$dates = $request->all();

    	// Валидация
    	if (@$dates['start'] == NULL)
    		$dates['start'] = date('Y-m-d H:i:s', 0);
    	else {
    		if ($this->validateDate($dates['start']))
    			$dates['start'] = date('Y-m-d', strtotime($dates['start'])).' 00:00:00';
    		else
    			$err[] = 'Не правильно указана начальная дата';
    	}

    	if (@$dates['end'] == NULL)
    		$dates['end'] = 'NOW()';
    	else {
    		if ($this->validateDate($dates['end']))
    			$dates['end'] = date('Y-m-d', strtotime($dates['end'])).' 23:59:59';
    		else
    			$err[] = 'Не правильно указана конечная дата';
    	}
        
    	if (!@$err) $list = App\General::date_between($dates['start'], $dates['end']);

        if (@$list) foreach ($list as $v) {
            @$cats[ $v->category ] += $v->summ;
            @$total_summ += $v->summ;
        }

  		return array(
  			'items' => @$list,
            'errors' => @$err,
            'cats' => @$cats,
            'total' => @$total_summ
  		);
    }

    function getCats() {
        $cats = DB::table('generals_categories')->get();
        foreach ($cats as $v) {
            $list[$v->id] = $v->name;
        } 
        return $list;
    }

	function validateDate($date) {
		$d = explode('.', $date);
		return checkdate((int)@$d[1], (int)@$d[0], (int)@$d[2]);
	}
}
