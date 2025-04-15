import React from 'react';
import styled from 'styled-components';
import { ShoppingBag } from 'lucide-react';

const TransactionContainer = styled.div`
    background: white;
    border-radius: 16px;
    padding: 16px;
`;

const Title = styled.h2`
    font-size: 1rem;
    font-weight: 600;
    margin-bottom: 16px;
    color: #1a1f2c;
`;

const TransactionItem = styled.div`
    display: flex;
    align-items: center;
    padding: 12px 0;
    border-bottom: 1px solid #f1f0fb;

    &:last-child {
        border-bottom: none;
    }
`;

const IconWrapper = styled.div`
    background: #f1f0fb;
    border-radius: 12px;
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 12px;
`;

const TransactionInfo = styled.div`
    flex: 1;
`;

const TransactionName = styled.div`
    font-weight: 500;
    color: #1a1f2c;
    margin-bottom: 4px;
`;

const TransactionDate = styled.div`
    font-size: 0.75rem;
    color: #666;
`;

const TransactionAmount = styled.div`
    font-weight: 500;
    color: #ea384c;
`;

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

const TransactionList = ({ transactions }: { transactions: Transaction[] }) => {
    console.log('transactions', transactions);
    return (
        <TransactionContainer>
            <Title>Transações</Title>
            {transactions.map((transaction) => (
                <TransactionItem key={transaction.id}>
                    <IconWrapper>
                        <ShoppingBag size={20} />
                    </IconWrapper>
                    <TransactionInfo>
                        <TransactionName>{transaction.description}</TransactionName>
                        <TransactionDate>{new Date(transaction.created_at).toLocaleDateString()}</TransactionDate>
                    </TransactionInfo>
                    <TransactionAmount>${Math.abs(transaction.amount).toFixed(2)}</TransactionAmount>
                </TransactionItem>
            ))}
        </TransactionContainer>
    );
};

export default TransactionList;
