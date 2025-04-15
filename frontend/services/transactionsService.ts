import api from './api';
interface MyTransactionsResponse {
    status: boolean;
    message: string;
    data: {
        id: number;
        reference: string;
        from_customer_id: number | null;
        to_customer_id: number;
        amount: number;
        type: string;
        status: string;
        description: string;
        metadata: string;
        reversed_by_admin_id: number | null;
        reversed_at: string | null;
        created_at: string;
        updated_at: string;
        deleted_at: string | null;
    }[];
}

const transactionsService = {
    async getMyTransactions(): Promise<MyTransactionsResponse> {
        try {
            const response = await api.get<MyTransactionsResponse>('/transaction/my-transactions');
            return response.data;
        } catch (error) {
            console.error('Erro ao buscar transações:', error);
            throw error;
        }
    },

    async deposit(to_customer_id: number, amount: number, description: string): Promise<MyTransactionsResponse> {
        try {
            const response = await api.post<MyTransactionsResponse>('/transaction/deposit', {
                to_customer_id,
                amount,
                description
            });
            return response.data;
        } catch (error) {
            console.error('Erro ao depositar:', error);
            throw error;
        }
    },

    async transfer(to_customer_id: number, amount: number, description: string): Promise<MyTransactionsResponse> {
        try {
            const response = await api.post<MyTransactionsResponse>('/transaction/transfer', {
                to_customer_id,
                amount,
                description
            });
            return response.data;
        } catch (error) {
            console.error('Erro ao transferir:', error);
            throw error;
        }
    },

    async revert(transaction_id: number): Promise<MyTransactionsResponse> {
        try {
            const response = await api.post<MyTransactionsResponse>('/transaction/revert', {
                transaction_id,
                admin_id: 1
            });
            return response.data;
        } catch (error) {
            console.error('Erro ao reverter:', error);
            throw error;
        }
    }
};

export default transactionsService;
