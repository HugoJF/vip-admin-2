import React from 'react';

export default function CardDeck({children}) {
    return (
        <div className="flex flex-wrap justify-center p-8">
            {children}
        </div>
    );
}