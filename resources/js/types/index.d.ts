import { LucideIcon } from 'lucide-react';
import type { Config } from 'ziggy-js';

export interface Auth {
    user: User;
}

export interface BreadcrumbItem {
    title: string;
    href: string;
}

export interface NavGroup {
    title: string;
    items: NavItem[];
}

export interface NavItem {
    title: string;
    href: string;
    icon?: LucideIcon | null;
    isActive?: boolean;
}

export interface SharedData {
    name: string;
    quote: { message: string; author: string };
    auth: Auth;
    ziggy: Config & { location: string };
    sidebarOpen: boolean;
    [key: string]: unknown;
}

export interface User {
    id: number;
    name: string;
    email: string;
    avatar?: string;
    email_verified_at: string | null;
    created_at: string;
    updated_at: string;
    role?: string;
    referral_code?: string;
    commission_rate?: number;
    is_active?: boolean;
    bio?: string;
    phone?: string;
    [key: string]: unknown;
}

export interface Program {
    id: number;
    name: string;
    description?: string;
    type: string;
    duration: string;
    price: number;
    commission_rate?: number;
    is_active: boolean;
    features?: string[];
    image_url?: string;
    created_at: string;
    updated_at: string;
    [key: string]: unknown;
}

export interface Referral {
    id: number;
    affiliate_id: number;
    program_id: number;
    customer_name: string;
    customer_email: string;
    customer_phone?: string;
    status: string;
    commission_amount?: number;
    commission_rate: number;
    completed_at?: string;
    notes?: string;
    customer_data?: Record<string, unknown>;
    created_at: string;
    updated_at: string;
    affiliate?: User;
    program?: Program;
    [key: string]: unknown;
}

export interface Click {
    id: number;
    affiliate_id: number;
    program_id?: number;
    ip_address: string;
    user_agent?: string;
    referrer_url?: string;
    landing_page?: string;
    metadata?: Record<string, unknown>;
    created_at: string;
    updated_at: string;
    affiliate?: User;
    program?: Program;
    [key: string]: unknown;
}

export interface Payout {
    id: number;
    affiliate_id: number;
    amount: number;
    status: string;
    method: string;
    payment_details?: Record<string, unknown>;
    processed_at?: string;
    notes?: string;
    transaction_id?: string;
    created_at: string;
    updated_at: string;
    affiliate?: User;
    [key: string]: unknown;
}

export interface PaginatedData<T> {
    data: T[];
    current_page: number;
    first_page_url: string;
    from: number;
    last_page: number;
    last_page_url: string;
    next_page_url: string | null;
    path: string;
    per_page: number;
    prev_page_url: string | null;
    to: number;
    total: number;
}
