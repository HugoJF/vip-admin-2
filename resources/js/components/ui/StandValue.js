import React from 'react';
import Tag from "./Tag";

export default function ({color = 'green', children}) {
    return (
        <td className="px-4">
            <Tag color={color}>
                {children}
            </Tag>
        </td>
    );
}