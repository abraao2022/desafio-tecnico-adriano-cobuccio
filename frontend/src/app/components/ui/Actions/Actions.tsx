import React from 'react';
import styled from 'styled-components';
import { ArrowDownToLine, ArrowUpToLine, MoreHorizontal } from 'lucide-react';

const ActionsContainer = styled.div`
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 16px;
    margin-bottom: 24px;
`;

const ActionButton = styled.button`
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 8px;
    background: none;
    border: none;
    cursor: pointer;
    padding: 12px;
    color: #1a1f2c;
    font-size: 0.75rem;

    &:hover {
        opacity: 0.8;
    }
`;

const IconWrapper = styled.div`
    background: #f1f0fb;
    border-radius: 50%;
    width: 48px;
    height: 48px;
    display: flex;
    align-items: center;
    justify-content: center;
`;

const Actions = ({setModalDeposit, setModalTransfer, setModalRevert}: {setModalDeposit: (modal: boolean) => void, setModalTransfer: (modal: boolean) => void, setModalRevert: (modal: boolean) => void}) => {
    return (
        <ActionsContainer>
            <ActionButton onClick={() => setModalDeposit(true)}>
                <IconWrapper>
                    <ArrowDownToLine size={24} />
                </IconWrapper>
                Depositar
            </ActionButton>
            <ActionButton onClick={() => setModalTransfer(true)}>
                <IconWrapper>
                    <ArrowUpToLine size={24} />
                </IconWrapper>
                Transferir
            </ActionButton>
            {/* <ActionButton>
                <IconWrapper>
                    <Wallet size={24} />
                </IconWrapper>
                Withdraw
            </ActionButton> */}
            <ActionButton onClick={() => setModalRevert(true)}>
                <IconWrapper>
                    <MoreHorizontal size={24} />
                </IconWrapper>
                Reverter
            </ActionButton>
        </ActionsContainer>
    );
};

export default Actions;
