<?php

namespace App\Exports;

use App\Models\UserModel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings; // Add this line

class UsersExport implements FromCollection, WithHeadings // Implement WithHeadings
{
    /**
     * Return a collection of the data that should be exported.
     *
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return UserModel::all();
    }

    /**
     * Define headings for each column.
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID', 'Level ID', 'Username', 'Name', 'Password', 'Created At', 'Updated At', 'Profile Picture'
        ];
    }
}
