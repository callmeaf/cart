<?php

namespace Callmeaf\Cart\App\Exports\Api\V1;

use Callmeaf\Cart\App\Models\Cart;
use Callmeaf\Cart\App\Repo\Contracts\CartRepoInterface;
use Illuminate\Contracts\Support\Responsable;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomChunkSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Excel;

class CartsExport implements FromCollection,WithHeadings,Responsable,WithMapping,WithCustomChunkSize
{
    use Exportable;

    /**
     * It's required to define the fileName within
     * the export class when making use of Responsable.
     */
    private $fileName = '';

    /**
     * Optional Writer Type
     */
    private $writerType = Excel::XLSX;

    /**
     * Optional headers
     */
    private $headers = [
        'Content-Type' => 'text/csv',
    ];

    private CartRepoInterface $cartRepo;
    public function __construct()
    {
        $this->cartRepo = app(CartRepoInterface::class);
        $this->fileName = $this->fileName ?: \Base::exportFileName(model: $this->cartRepo->getModel()::class,extension: $this->writerType);
    }

    public function collection()
    {
        if(\Base::getTrashedData()) {
            $this->cartRepo->trashed();
        }

        $this->cartRepo->latest()->search();

        if(\Base::getAllPagesData()) {
            return $this->cartRepo->lazy();
        }

        return $this->cartRepo->paginate();
    }

    public function headings(): array
    {
        return [
           // 'status',
        ];
    }

    /**
     * @param Cart $row
     * @return array
     */
    public function map($row): array
    {
        return [
            // $row->status?->value,
        ];
    }

    public function chunkSize(): int
    {
        return \Base::config('export_chunk_size');
    }
}
