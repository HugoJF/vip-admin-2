import React from 'react';

export default function StandRow({children}) {
    return (
        <tr className="border-t border-b border-grey-light">
            {children}
        </tr>
    );
}