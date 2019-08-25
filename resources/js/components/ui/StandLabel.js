import React from 'react';

export default function StandLabel({children}) {
    return (
        <td className="px-4 py-2 text-lg text-grey-darkest font-normal">
            {children}
        </td>
    );
}