'use client';
import React, { useEffect, useState } from 'react';
import { Container } from '@mui/material';
import styled from 'styled-components';
import Balance from '../components/ui/Balance/Balance';
import Actions from '../components/ui/Actions/Actions';
import TransactionList from '../components/ui/TransactionList/TransactionList';
import transactionsService from '../../../services/transactionsService';
import DepositModal from '../components/ui/DepositModal/DepositModal';
import TransferModal from '../components/ui/TransferModal/TransferModal';
import RevertModal from '../components/ui/RevertModal/RevertModal';
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

interface Transaction {
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
}

const MainContainer = styled(Container)`
    padding-top: 24px;
    padding-bottom: 24px;
    max-width: 480px !important;
`;

const Index = () => {
    const [transactions, setTransactions] = useState<Transaction[]>([]);
    const [modalDeposit, setModalDeposit] = useState(false);
    const [modalTransfer, setModalTransfer] = useState(false);
    const [modalRevert, setModalRevert] = useState(false);
    const [loading, setLoading] = useState(true);
    const [user, setUser] = useState<User | null>(null);

    useEffect(() => {
        const fetchTransactions = async () => {
            try {
                const response = await transactionsService.getMyTransactions();
                setTransactions(response.data);

                const responseInfoMe = await authService.getMe();
                if (responseInfoMe) {
                    setUser(responseInfoMe);
                }
            } catch (error) {
                console.error('Erro ao carregar transações:', error);
            } finally {
                setLoading(false);
            }
        };

        fetchTransactions();
    }, [modalDeposit, modalTransfer, modalRevert]);

    return (
        <MainContainer>
            <Balance balance={user?.customer?.balance || 0} />
            <Actions setModalDeposit={setModalDeposit} setModalTransfer={setModalTransfer} setModalRevert={setModalRevert} />
            {loading ? <p>Carregando transações...</p> : <TransactionList transactions={transactions} />}
            <DepositModal open={modalDeposit} handleClose={() => setModalDeposit(false)} />
            <TransferModal open={modalTransfer} handleClose={() => setModalTransfer(false)} />
            <RevertModal open={modalRevert} handleClose={() => setModalRevert(false)} />
        </MainContainer>
    );
};

export default Index;
