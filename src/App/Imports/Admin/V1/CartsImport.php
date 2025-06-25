<?php

namespace Callmeaf\Cart\App\Imports\Admin\V1;

use Callmeaf\Base\App\Services\Importer;
use Callmeaf\Cart\App\Enums\CartStatus;
use Callmeaf\Cart\App\Repo\Contracts\CartRepoInterface;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class CartsImport extends Importer implements ToCollection,WithChunkReading,WithStartRow,SkipsEmptyRows,WithValidation,WithHeadingRow
{
    private CartRepoInterface $cartRepo;

    public function __construct()
    {
        $this->cartRepo = app(CartRepoInterface::class);
    }

    public function collection(Collection $collection)
    {
        $this->total = $collection->count();

        foreach ($collection as $row) {
            $this->cartRepo->freshQuery()->create([
                // 'status' => $row['status'],
            ]);
            ++$this->success;
        }
    }

    public function chunkSize(): int
    {
        return \Base::config('import_chunk_size');
    }

    public function startRow(): int
    {
        return 2;
    }

    public function rules(): array
    {
        $table = $this->cartRepo->getTable();
        return [
            // 'status' => ['required',Rule::enum(CartStatus::class)],
        ];
    }

}
