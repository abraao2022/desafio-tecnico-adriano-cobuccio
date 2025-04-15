import React from 'react';
import styled from 'styled-components';

const BalanceCard = styled.div`
    background: linear-gradient(135deg, #8e24aa 0%, #6a1b9a 100%);
    color: white;
    border-radius: 16px;
    padding: 24px;
    margin-bottom: 24px;
`;

const BalanceLabel = styled.div`
    font-size: 0.875rem;
    opacity: 0.9;
    margin-bottom: 8px;
`;

const BalanceAmount = styled.div`
    font-size: 2rem;
    font-weight: bold;
`;

const Balance = ({ balance }: { balance: number | null }) => {
    return (
        <BalanceCard>
            <BalanceLabel>Saldo Atual</BalanceLabel>
            <BalanceAmount>R$ {balance || 0}</BalanceAmount>
        </BalanceCard>
    );
};

export default Balance;
