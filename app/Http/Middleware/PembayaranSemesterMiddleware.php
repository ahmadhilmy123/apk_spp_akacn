<?php

namespace App\Http\Middleware;

use Closure, Auth;
use App\Models\Semester;
use Illuminate\Http\Request;

class PembayaranSemesterMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $semester = Semester::findOrFail(request('semester_id'));
        $mhs = Auth::user()->mahasiswa;
        
        if ($semester->prodi_id != $mhs->prodi_id) {
            abort(403);
        }

        return $next($request);
    }
}
