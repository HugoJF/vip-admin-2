import React from 'react';

export default function SidebarLink({title, current = false, href = '#'}) {
    return (
        <li className="my-2 ml-3 group">
            <a target="_blank" className="trans flex items-center text-grey no-underline text-sm group-hover:text-grey-light" href={href}>
                <span className="mr-1 w-4 h-4" data-feather="chevron-right"/>
                {title}
                {current && <span className="sr-only">(current)</span>}
            </a>
        </li>
    );
}