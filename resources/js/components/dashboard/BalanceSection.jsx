import React from 'react';
import { maskBalance } from './utils';

const BalanceSection = ({ totalBalance, isBalanceHidden }) => {
    return (
        <div className="px-0 sm:px-1">
            <p className="text-xs uppercase font-semibold text-gray-400 mb-2 tracking-widest">
                BALANCE
            </p>
            <p className="text-3xl font-bold text-white font-mono">
                {maskBalance(isBalanceHidden, totalBalance)}
            </p>
            <p className="text-xs text-gray-400 mt-1">Your liquid balance</p>
        </div>
    );
};

export default BalanceSection;

