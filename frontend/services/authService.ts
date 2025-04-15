import api from './api';

interface LoginResponse {
    status: boolean;
    message: string;
    user: {
        id: number;
        name: string;
        email: string;
    };
    access_token: string;
    type: string;
}

const authService = {
    async login(email: string, password: string): Promise<LoginResponse> {
        try {
            const response = await api.post<LoginResponse>('/login', {
                email,
                password
            });
            return response.data;
        } catch (error) {
            console.error('Erro ao fazer login:', error);
            throw error;
        }
    },

    async logout() {
        try {
            await api.post('/logout');
        } catch (error) {
            console.error('Erro ao fazer logout:', error);
            throw error;
        }
    },

    async getMe() {
        try {
            const response = await api.get('/me');
            return response.data;
        } catch (error) {
            console.error('Erro ao buscar o usuário:', error);
            throw error;
        }
    }
};

export default authService;
