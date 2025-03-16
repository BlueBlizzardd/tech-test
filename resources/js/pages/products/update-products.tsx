import { Head, useForm } from '@inertiajs/react';
import { LoaderCircle } from 'lucide-react';
import { FormEventHandler } from 'react';

import InputError from '@/components/input-error';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AuthLayout from '@/layouts/auth-layout';
import { Product } from '@/types';

type ProductForm = Omit<Product, 'id' | 'created_at' | 'updated_at'>;

interface ProductProps {
    product: Product;
    status?: string;
}

export default function ProductUpdateForm({ product, status }: ProductProps) {
    const { data, setData, patch, processing, errors } = useForm<Required<ProductForm>>({
        sku: product.sku,
        name: product.name,
        description: product.description,
        price: product.price,
        stock: product.stock
    });

    const submit: FormEventHandler = (e) => {
        e.preventDefault();
        patch(route('edit-product', product.id));
    };

    return (
        <AuthLayout title="Product Form" description="Enter the product details below">
            <Head title="Product Form" />

            <form className="flex flex-col gap-6" onSubmit={submit}>
                <div className="grid gap-6">
                    <div className="grid gap-2">
                        <Label htmlFor="sku">SKU</Label>
                        <Input
                            id="sku"
                            type="sku"
                            required
                            autoFocus
                            tabIndex={1}
                            autoComplete="sku"
                            value={data.sku}
                            onChange={(e) => setData('sku', e.target.value)}
                            placeholder="123456789"
                        />
                        <InputError message={errors.sku} />
                    </div>

                    <div className="grid gap-2">
                        <Label htmlFor="name">Name</Label>
                        <Input
                            id="name"
                            type="text"
                            required
                            tabIndex={2}
                            autoComplete="name"
                            value={data.name}
                            onChange={(e) => setData('name', e.target.value)}
                            placeholder="Pollo"
                        />
                        <InputError message={errors.name} />
                    </div>

                    <div className="grid gap-2">
                        <Label htmlFor="description">Description</Label>
                        <Input
                            id="description"
                            type="text"
                            required
                            tabIndex={2}
                            autoComplete="Lorem ipsum sit dolor amet"
                            value={data.description}
                            onChange={(e) => setData('description', e.target.value)}
                            placeholder="Pollo"
                        />
                        <InputError message={errors.description} />
                    </div>

                    <div className="grid gap-2">
                        <Label htmlFor="price">Price ($)</Label>
                        <Input
                            id="price"
                            type="number"
                            required
                            tabIndex={2}
                            autoComplete="1.0"
                            value={data.price}
                            onChange={(e) => setData('price', Number(e.target.value))}
                            placeholder="1.0"
                        />
                        <InputError message={errors.price} />
                    </div>

                    <div className="grid gap-2">
                        <Label htmlFor="stock">Stock</Label>
                        <Input
                            id="stock"
                            type="number"
                            required
                            tabIndex={2}
                            autoComplete="1"
                            value={data.stock}
                            onChange={(e) => setData('stock', Number(e.target.value))}
                            placeholder="0"
                        />
                        <InputError message={errors.stock} />
                    </div>

                    <Button type="submit" className="mt-4 w-full" tabIndex={4} disabled={processing}>
                        {processing && <LoaderCircle className="h-4 w-4 animate-spin" />}
                        Update
                    </Button>
                </div>

            </form>

            {status && <div className="mb-4 text-center text-sm font-medium text-green-600">{status}</div>}
        </AuthLayout>
    );
}

