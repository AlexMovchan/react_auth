import React, { Component } from 'react';
import './header.css';

export default class Header extends Component {
    constructor() {
        super();
    }

    render() {
        return (
            <header>
                <ul>
                    <li><a href="">Home</a></li>
                    <li><a href="">MySql</a></li>
                </ul>
            </header>
        )
    }
}