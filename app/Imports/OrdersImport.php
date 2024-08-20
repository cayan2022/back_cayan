<?php

namespace App\Imports;

use App\Models\Branch;
use App\Models\Category;
use App\Models\Country;
use App\Models\Order;
use App\Models\OrderHistory;
use App\Models\Source;
use App\Models\Status;
use App\Models\SubStatus;
use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;

class OrdersImport implements ToCollection, WithStartRow
{
    /**
     * @return int
     */
    public function startRow(): int
    {
        return 2;
    }

    /**
     * @param Collection $collection
     *
     * @return \Illuminate\Database\Eloquent\Collection|null
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $user = User::query()->withoutTrashed()
                ->where(['phone' => $row[8], 'email' => $row[9]])
                ->orWhere('phone', $row[8])
                ->orWhere('email', $row[9])
                ->firstOr(function () use ($row) {
                    return User::create([
                        'phone' => $row[8],
                        'email' => $row[9],
                        'country_id' => Country::first()->id,
                        'name' => $row[7],
                        'type' => User::PATIENT
                    ]);
                });

            $user->update(['phone' => $row[8], 'email' => $row[9]]);

            $branch = Branch::whereTranslationLike('name', "%$row[2]%")->first();
            if (!$branch) {
                $branch = Branch::create([
                    'name' => $row[2]
                ]);
            }

            $source = Source::whereTranslationLike('name', "%$row[3]%")->first();
            if (!$source) {
                $source = Source::create([
                    'name' => $row[3]
                ]);
            }

            $category = Category::whereTranslationLike('name', "%$row[4]%")->first();
            if (!$category) {
                $category = Category::create([
                    'name' => $row[4]
                ]);
            }

            $status = Status::whereTranslationLike('name', "%$row[5]%")->first();
            if (!$status) {
                $status = Status::create([
                    'name' => $row[5]
                ]);
            }

            $order = Order::create([
                'category_id' => $category->id,
                'branch_id' => $branch->id,
                'source_id' => $source->id,
                'user_id' => $user->id,
                'status_id' => $status->id,
                'created_at' => $row[1]
            ]);


            $sub_status = SubStatus::whereTranslationLike('name', "%$row[10]%")->first();

            OrderHistory::create([
                'order_id' => $order->id,
                'sub_status_id' => $sub_status->id,
                'created_at' => $row[11],
                'user_id' => $user->id,
                'description' => $row[12]
            ]);

        }
    }


}
