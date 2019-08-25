import React from 'react';

export default function Step({title, step = 1, completed = false}) {
    return (
        <div className="flex flex-col justify-center">
            <div className={`flex flex-no-shrink h-10 w-10 z-10 justify-center items-center bg-white bg-grey-lightest border-2 ${completed ? 'border-green' : 'border-grey-dark'} rounded-full`}>
                <span className="text-grey-darkest text-xl font-mono font-bold">{step}</span>
            </div>
            {
                title
                    ?
                    <div className="relative flex justify-center pin-l pin-t pin-r">
                        <p className="text-center absolute h-8 whitespace-no-wrap text-grey-darkest">{title}</p>
                    </div>
                    :
                    undefined
            }
        </div>
    );
}