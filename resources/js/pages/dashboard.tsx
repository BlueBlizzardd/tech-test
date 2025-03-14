import { PlaceholderPattern } from '@/components/ui/placeholder-pattern';
import { Table, TableBody, TableCaption, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import AppLayout from '@/layouts/app-layout';
import { Product, type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/react';

type DashboardProps = {
    products: Product[];
}

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];

export default function Dashboard({ products }: DashboardProps) {
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Dashboard" />
            <div className="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
                <div className="grid auto-rows-min gap-4 md:grid-cols-3">
                    <Table>
                        <TableCaption>Lista de Productos.</TableCaption>
                        <TableHeader>
                            <TableRow>
                                <TableHead>ID</TableHead>
                                <TableHead>SKU</TableHead>
                                <TableHead>Nombre</TableHead>
                                <TableHead>Descripcion</TableHead>
                                <TableHead>Precio</TableHead>
                                <TableHead>Cantidad</TableHead>
                                <TableHead>Creado En</TableHead>
                                <TableHead>Actualizado En</TableHead>
                            </TableRow>
                        </TableHeader>
                        <TableBody>
                            {products.map(product =>
                                <TableRow>
                                    <TableCell>{product.id}</TableCell>
                                    <TableCell>{product.sku}</TableCell>
                                    <TableCell>{product.name}</TableCell>
                                    <TableCell>{product.description}</TableCell>
                                    <TableCell>{product.price}</TableCell>
                                    <TableCell>{product.stock}</TableCell>
                                    <TableCell>{product.created_at}</TableCell>
                                    <TableCell>{product.updated_at}</TableCell>
                                </TableRow>
                            )}
                        </TableBody>
                    </Table>
                </div>
                {/*
                    <div className="border-sidebar-border/70 dark:border-sidebar-border relative min-h-[100vh] flex-1 overflow-hidden rounded-xl border md:min-h-min">
                    <PlaceholderPattern className="absolute inset-0 size-full stroke-neutral-900/20 dark:stroke-neutral-100/20" />
                </div>
                */}
            </div>
        </AppLayout>
    );
}
