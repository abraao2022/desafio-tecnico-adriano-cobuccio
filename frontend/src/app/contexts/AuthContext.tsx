'use client';

import { createContext, useContext, useState, useEffect, ReactNode } from 'react';
import { useRouter } from 'next/navigation';
import authService from '../../../services/authService';

interface Customer {
    id: number;
    user_id: number;
    balance: number;
    phone_number: string | null;
    last_transaction_at: string | null;
    blocked: boolean;
}

interface User {
    id: number;
    name: string;
    email: string;
    email_verified_at?: string | null;
    type?: string;
    cpf?: string;
    created_at?: string;
    updated_at?: string;
    customer?: Customer | null;
}

interface AuthContextType {
    user: User | null;
    login: (email: string, password: string) => Promise<void>;
    logout: () => Promise<void>;
    isAuthenticated: boolean;
    isLoading: boolean;
}

const AuthContext = createContext<AuthContextType | undefined>(undefined);

export function AuthProvider({ children }: { children: ReactNode }) {
    const [user, setUser] = useState<User | null>(null);
    const [isLoading, setIsLoading] = useState(true);
    const router = useRouter();

    useEffect(() => {
        const verifyAuth = async () => {
            const token = localStorage.getItem('token');
            if (!token) {
                setIsLoading(false);
                return;
            }

            try {
                const response = await authService.getMe();
                if (response) {
                    setUser(response);
                } else {
                    // localStorage.removeItem('token');
                    // localStorage.removeItem('user');
                }
            } catch (error) {
                console.error('Error verifying authentication:', error);
                // localStorage.removeItem('token');
                // localStorage.removeItem('user');
            } finally {
                setIsLoading(false);
            }
        };

        verifyAuth();
    }, []);

    const login = async (email: string, password: string) => {
        try {
            const response = await authService.login(email, password);
            console.log('response', response);

            localStorage.setItem('token', response.access_token);
            localStorage.setItem('user', JSON.stringify(response.user));
            setUser(response.user);
            router.push('/carteira');
        } catch (error: unknown) {
            if (error instanceof Error) {
                throw new Error(error.message || 'Erro ao fazer login');
            } else {
                throw new Error('Unknown error occurred');
            }
        }
    };

    const logout = async () => {
        try {
            await authService.logout();
        } catch (error) {
            console.error('Erro ao fazer logout:', error);
        } finally {
            localStorage.removeItem('token');
            localStorage.removeItem('user');
            setUser(null);
            router.push('/login');
        }
    };

    return (
        <AuthContext.Provider value={{ user, login, logout, isAuthenticated: !!user, isLoading }}>
            {!isLoading && children}
        </AuthContext.Provider>
    );
}

export function useAuth() {
    const context = useContext(AuthContext);
    if (context === undefined) {
        throw new Error('useAuth must be used within an AuthProvider');
    }
    return context;
}
