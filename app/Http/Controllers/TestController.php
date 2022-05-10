<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use DB;

class TestController extends Controller
{
    public function getSql() {

        $sql = ('SELECT * 
                    FROM 
                        label
                    WHERE 
                        id = :id');

        //dd($sql);

        $query = DB::select($sql, ['id' => 1]);

       // $response = json_encode($query);

       // return json_encode($query);
        return $query;
    }

    public function countAll() {

        $sql = ('SELECT count(*)
                    from label');

        return DB::select($sql);
    }

    public function getTable() {
        
        $labels = DB::select('SELECT * 
                                    FROM label
                                    ORDER BY id');

        return view('table/table', ['labels' => $labels]);
    }

    public function changeLabel(Request $request, $labelid) {

        $oldname = $request->input('name');

        $name = $oldname . ' ' . $labelid;

        DB::update('UPDATE label
                    set name = ?
                    where id = ?',[$name, $labelid]);

        $origin = preg_replace("/[\s\d*]+/", '', $name);

        $response = response()->json(['updated' => $name,
                                        'origin' => $origin,
                                        'result' => 0]);

        return $response;
    }

    public function insertLabel(Request $request, $labelid) {
        // insert new one with name + id + 1

        $check = DB::table('label')->count();

        $oldname = $request->input('name');

        $id = $labelid + 1;

        $newname = $oldname . ' ' . $id;

        DB::insert('INSERT into label (name) VALUES (?)', [$newname]);

        $response = response()->json(['insert'=> $newname,
                                        'checkstring' => $check,
                                        'result' => 0]);

        return $response;
    }

    public function updateLabel(Request $request, $labelid) {
        // bring back the old label

        $name = $request->input('name');

        $origin = preg_replace("/[\s\d*]+/", '', $name);

        DB::update('UPDATE label
                            set name = ?
                            where id = ?',[$origin, $labelid]);

        $response = response()->json(['origin'=> $origin,
                                        'result' => 0]);

        return $response;

    }

    public function deleteLabel(Request $request, $labelid) {
        // delete entry
        //if (count(Label::where('id', '=', $labelid)->get()) == 1) {
            DB::delete("DELETE FROM label
                            WHERE id = ?", [$labelid]);

            $response = response()->json([
                                        'id' => $labelid,
                                        'result' => 0]);
        return $response;
    }
}
